<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_Edificios_Reparados {

	/**
	 * These are the regular expression rules that we use to validate the product ID and product nombre
	 * alpha-numeric, dashes, underscores, or periods
	 *
	 * @var string
	 */
	public $product_id_rules = '\.a-z0-9_-';

	/**
	 * These are the regular expression rules that we use to validate the product ID and product nombre
	 * alpha-numeric, dashes, underscores, colons or periods
	 *
	 * @var string
	 */
	public $product_nombre_rules = '\w \-\.\:';

	/**
	 * only allow safe product nombres
	 *
	 * @var bool
	 */
	public $product_nombre_safe = TRUE;

	// --------------------------------------------------------------------------

	/**
	 * Reference to CodeIgniter instance
	 *
	 * @var object
	 */
	protected $CI;

	/**
	 * Contents of the cart
	 *
	 * @var array
	 */
	protected $_edificios_reparados_contents = array();

	/**
	 * Shopping Class Constructor
	 *
	 * The constructor loads the Session class, used to store the shopping cart contents.
	 *
	 * @param	array
	 * @return	void
	 */
	public function __construct($params = array())
	{
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();

		// Are any config settings being passed manually?  If so, set them
		$config = is_array($params) ? $params : array();

		// Load the Sessions class
		$this->CI->load->driver('session', $config);

		// Grab the shopping cart array from the session table
		$this->_edificios_reparados_contents = $this->CI->session->userdata('edificios_reparados_contents');
		if ($this->_edificios_reparados_contents === NULL)
		{
			// No cart exists so we'll set some base values
			$this->_edificios_reparados_contents = array('cart_total' => 0, 'total_edificios_reparados' => 0);
		}

		log_message('info', 'Cart Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Insert edificios_reparados into the cart and save it to the session table
	 *
	 * @param	array
	 * @return	bool
	 */
	public function insert($edificios_reparados = array())
	{
		// Was any cart data passed? No? Bah...
		if ( ! is_array($edificios_reparados) OR count($edificios_reparados) === 0)
		{
			log_message('error', 'The insert method must be passed an array containing data.');
			return FALSE;
		}

		// You can either insert a single product using a one-dimensional array,
		// or multiple products using a multi-dimensional one. The way we
		// determine the array type is by looking for a required array key nombred "id"
		// at the top level. If it's not found, we will assume it's a multi-dimensional array.

		$save_cart = FALSE;
		if (isset($edificios_reparados['id']))
		{
			if (($rowid = $this->_insert($edificios_reparados)))
			{
				$save_cart = TRUE;
			}
		}
		else
		{
			foreach ($edificios_reparados as $val)
			{
				if (is_array($val) && isset($val['id']))
				{
					if ($this->_insert($val))
					{
						$save_cart = TRUE;
					}
				}
			}
		}

		// Save the cart data if the insert was successful
		if ($save_cart === TRUE)
		{
			$this->_save_cart();
			return isset($rowid) ? $rowid : TRUE;
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Insert
	 *
	 * @param	array
	 * @return	bool
	 */
	protected function _insert($edificios_reparados = array())
	{
		// Was any cart data passed? No? Bah...
		if ( ! is_array($edificios_reparados) OR count($edificios_reparados) === 0)
		{
			log_message('error', 'The insert method must be passed an array containing data.');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Does the $edificios_reparados array contain an id, quantity, price, and nombre?  These are required
		if ( ! isset($edificios_reparados['id'], $edificios_reparados['cantidad'], $edificios_reparados['numero'], $edificios_reparados['nombre']))
		{
			log_message('error', 'The cart array must contain a product ID, quantity, and nombre.');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Prep the quantity. It can only be a number.  Duh... also trim any leading zeros
		$edificios_reparados['cantidad'] = (int) $edificios_reparados['cantidad'];

		// If the quantity is zero or blank there's nothing for us to do
		if ($edificios_reparados['cantidad'] == 0)
		{
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Validate the product ID. It can only be alpha-numeric, dashes, underscores or periods
		// Not totally sure we should impose this rule, but it seems prudent to standardize IDs.
		// Note: These can be user-specified by setting the $this->product_id_rules variable.
		if ( ! preg_match('/^['.$this->product_id_rules.']+$/i', $edificios_reparados['id']))
		{
			log_message('error', 'Invalid product ID.  The product ID can only contain alpha-numeric characters, dashes, and underscores');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Validate the product nombre. It can only be alpha-numeric, dashes, underscores, colons or periods.
		// Note: These can be user-specified by setting the $this->product_nombre_rules variable.
		if ($this->product_nombre_safe && ! preg_match('/^['.$this->product_nombre_rules.']+$/i'.(UTF8_ENABLED ? 'u' : ''), $edificios_reparados['nombre']))
		{
			log_message('error', 'An invalid nombre was submitted as the product nombre: '.$edificios_reparados['nombre'].' The nombre can only contain alpha-numeric characters, dashes, underscores, colons, and spaces');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// We now need to create a unique identifier for the edificio being inserted into the cart.
		// Every time something is added to the cart it is stored in the master cart array.
		// Each row in the cart array, however, must have a unique index that identifies not only
		// a particular product, but makes it possible to store identical products with different options.
		// For example, what if someone buys two identical t-shirts (same product ID), but in
		// different sizes?  The product ID (and other attributes, like the nombre) will be identical for
		// both sizes because it's the same shirt. The only difference will be the size.
		// Internally, we need to treat identical submissions, but with different options, as a unique product.
		// Our solution is to convert the options array to a string and MD5 it along with the product ID.
		// This becomes the unique "row ID"

		// No options were submitted so we simply MD5 the product ID.
		// Technically, we don't need to MD5 the ID in this case, but it makes
		// sense to standardize the format of array indexes for both conditions
		$rowid = md5($edificios_reparados['id']);
		$edificios_reparados['rowid'] = $rowid;

		// --------------------------------------------------------------------

		// Now that we have our unique "row ID", we'll add our cart edificios_reparados to the master array
		// grab quantity if it's already there and add it on

		// Re-create the entry, just to make sure our index contains only the data from this submission
		$list = $this->contents();
		$contador = 0;

		foreach ($list as $anterior)
        {
            if($edificios_reparados['numero'] === $anterior['numero'])
            {
            	$contador = 1;
            }
        }

        if($contador<1)
        {
			$this->_edificios_reparados_contents[$rowid] = $edificios_reparados;
        }
        return $rowid;
	}

	// --------------------------------------------------------------------

	/**
	 * Update the cart
	 *
	 * This function permits the quantity of a given edificio to be changed.
	 * Typically it is called from the "view cart" page if a user makes
	 * changes to the quantity before checkout. That array must contain the
	 * product ID and quantity for each edificio.
	 *
	 * @param	array
	 * @return	bool
	 */
	public function update($edificios_reparados = array())
	{
		// Was any cart data passed?
		if ( ! is_array($edificios_reparados) OR count($edificios_reparados) === 0)
		{
			return FALSE;
		}

		// You can either update a single product using a one-dimensional array,
		// or multiple products using a multi-dimensional one.  The way we
		// determine the array type is by looking for a required array key nombred "rowid".
		// If it's not found we assume it's a multi-dimensional array
		$save_cart = FALSE;
		if (isset($edificios_reparados['rowid']))
		{
			if ($this->_update($edificios_reparados) === TRUE)
			{
				$save_cart = TRUE;
			}
		}
		else
		{
			foreach ($edificios_reparados as $val)
			{
				if (is_array($val) && isset($val['rowid']))
				{
					if ($this->_update($val) === TRUE)
					{
						$save_cart = TRUE;
					}
				}
			}
		}

		// Save the cart data if the insert was successful
		if ($save_cart === TRUE)
		{
			$this->_save_cart();
			return TRUE;
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Update the cart
	 *
	 * This function permits changing edificio properties.
	 * Typically it is called from the "view cart" page if a user makes
	 * changes to the quantity before checkout. That array must contain the
	 * rowid and quantity for each edificio.
	 *
	 * @param	array
	 * @return	bool
	 */
	protected function _update($edificios_reparados = array())
	{
		// Without these array indexes there is nothing we can do
		if ( ! isset($edificios_reparados['rowid'], $this->_edificios_reparados_contents[$edificios_reparados['rowid']]))
		{
			return FALSE;
		}

		// Prep the quantity
		if (isset($edificios_reparados['cantidad']))
		{
			$edificios_reparados['cantidad'] = $edificios_reparados['cantidad'];
			// Is the quantity zero?  If so we will remove the edificio from the cart.
			// If the quantity is greater than zero we are updating
			if ($edificios_reparados['cantidad'] == 0)
			{
				unset($this->_edificios_reparados_contents[$edificios_reparados['rowid']]);
				return TRUE;
			}
		}

		// find updatable keys
		$keys = array_intersect(array_keys($this->_edificios_reparados_contents[$edificios_reparados['rowid']]), array_keys($edificios_reparados));

		// product id & nombre shouldn't be changed
		foreach (array_diff($keys, array('id', 'nombre')) as $key)
		{
			$this->_edificios_reparados_contents[$edificios_reparados['rowid']][$key] = $edificios_reparados[$key];
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Save the cart array to the session DB
	 *
	 * @return	bool
	 */
	protected function _save_cart()
	{
		// Let's add up the individual prices and set the cart sub-total
		$this->_edificios_reparados_contents['total_edificios_reparados'] = $this->_edificios_reparados_contents['cart_total'] = 0;
		foreach ($this->_edificios_reparados_contents as $key => $val)
		{
			// We make sure the array contains the proper indexes
			if ( ! is_array($val) OR ! isset($val['cantidad']))
			{
				continue;
			}

			$this->_edificios_reparados_contents['total_edificios_reparados'] += $val['cantidad'];
		}

		// Is our cart empty? If so we delete it from the session
		if (count($this->_edificios_reparados_contents) <= 2)
		{
			$this->CI->session->unset_userdata('edificios_reparados_contents');

			// Nothing more to do... coffee time!
			return FALSE;
		}

		// If we made it this far it means that our cart has data.
		// Let's pass it to the Session class so it can be stored
		$this->CI->session->set_userdata(array('edificios_reparados_contents' => $this->_edificios_reparados_contents));

		// Woot!
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Total
	 *
	 * @return	int
	 */
	public function total()
	{
		return $this->_edificios_reparados_contents['cart_total'];
	}

	// --------------------------------------------------------------------

	/**
	 * Remove edificio
	 *
	 * Removes an edificio from the cart
	 *
	 * @param	int
	 * @return	bool
	 */
	 public function remove($rowid)
	 {
		// unset & save
		unset($this->_edificios_reparados_contents[$rowid]);
		$this->_save_cart();
		return TRUE;
	 }

	// --------------------------------------------------------------------

	/**
	 * Total edificios_reparados
	 *
	 * Returns the total edificio count
	 *
	 * @return	int
	 */
	public function total_edificios_reparados()
	{
		return $this->_edificios_reparados_contents['total_edificios_reparados'];
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Contents
	 *
	 * Returns the entire cart array
	 *
	 * @param	bool
	 * @return	array
	 */
	public function contents($newest_first = FALSE)
	{
		// do we want the newest first?
		$cart = ($newest_first) ? array_reverse($this->_edificios_reparados_contents) : $this->_edificios_reparados_contents;

		// Remove these so they don't create a problem when showing the cart table
		unset($cart['total_edificios_reparados']);
		unset($cart['cart_total']);

		return $cart;
	}

	// --------------------------------------------------------------------

	/**
	 * Get cart edificio
	 *
	 * Returns the details of a specific edificio in the cart
	 *
	 * @param	string	$row_id
	 * @return	array
	 */
	public function get_edificio($row_id)
	{
		return (in_array($row_id, array('total_edificios_reparados', 'cart_total'), TRUE) OR ! isset($this->_edificios_reparados_contents[$row_id]))
			? FALSE
			: $this->_edificios_reparados_contents[$row_id];
	}

	// --------------------------------------------------------------------

	/**
	 * Has options
	 *
	 * Returns TRUE if the rowid passed to this function correlates to an edificio
	 * that has options associated with it.
	 *
	 * @param	string	$row_id = ''
	 * @return	bool
	 */
	public function has_options($row_id = '')
	{
		return (isset($this->_edificios_reparados_contents[$row_id]['options']) && count($this->_edificios_reparados_contents[$row_id]['options']) !== 0);
	}

	// --------------------------------------------------------------------

	/**
	 * Product options
	 *
	 * Returns the an array of options, for a particular product row ID
	 *
	 * @param	string	$row_id = ''
	 * @return	array
	 */
	public function product_options($row_id = '')
	{
		return isset($this->_edificios_reparados_contents[$row_id]['options']) ? $this->_edificios_reparados_contents[$row_id]['options'] : array();
	}

	// --------------------------------------------------------------------

	/**
	 * Format Number
	 *
	 * Returns the supplied number with commas and a decimal point.
	 *
	 * @param	float
	 * @return	string
	 */
	public function format_number($n = '')
	{
		return ($n === '') ? '' : number_format( (float) $n, 2, '.', ',');
	}

	// --------------------------------------------------------------------

	/**
	 * Destroy the cart
	 *
	 * Empties the cart and kills the session
	 *
	 * @return	void
	 */
	public function destroy()
	{
		$this->_edificios_reparados_contents = array('cart_total' => 0, 'total_edificios_reparados' => 0);
		$this->CI->session->unset_userdata('edificios_reparados_contents');
	}

}
