<?php
	/**
	* The admins class
	* It contains all action and behaviours admins may have
	*/
	class Admins
	{

		private $dbh = null;

		public function __construct($db)
		{
			$this->dbh = $db->dbh;
		}

		public function loginAdmin($user_name, $user_pwd)
		{
			//Un-comment this to see a cryptogram of a user_pwd 
			// echo session::hashuser_pwd($user_pwd);
			// die;
			$request = $this->dbh->prepare("SELECT user_name, user_pwd FROM kp_user WHERE user_name = ?");
	        if($request->execute( array($user_name) ))
	        {
	        	// This is an array of objects.
	        	// Remember we setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); in config/dbconnection.php
	        	$data = $request->fetchAll();
	        	
	        	// But if things are right, the array should contain only one object, the corresponding user
	        	// so, we can do this
	        	$data = $data[0];

	        	return session::passwordMatch($user_pwd, $data->user_pwd) ? true : false;

	        }else{
	        	return false;
	        }

		}

		/**
		 * Check if the admin user_name is unique
		 * If though we've set this criteria in our database,
		 * It's good to make sure the user is not try that
		 * @param   $user_name The user_name
		 * @return Boolean If the user_name is already usedor not
		 * 
		 */
		public function adminExists( $user_name )
		{
			$request = $this->dbh->prepare("SELECT user_name FROM kp_dist WHERE user_name = ?");
			$request->execute([$user_name]);
			$Admindata = $request->fetchAll();
			return sizeof($Admindata) != 0;
		}

		/**
		 * Compare two user_pwds
		 * @param String $user_pwd1, $user_pwd2 The two user_pwds
		 * @return  Boolean Either true or false
		 */

		public function ArepasswordSame( $user_pwd1, $user_pwd2 )
		{
			return strcmp( $user_pwd1, $user_pwd2 ) == 0;
		}


	/**
	 * ADMIN RELATED FUNCTIONS ###################################################################################################################
	 */
		
		/**
		 * Create a new row of admin
		 * @param String $user_name New admin user_name
		 * @param String $user_pwd New Admin user_pwd
		 * @return Boolean The final state of the action
		 * 
		 */
		
		public function addNewAdmin($user_name, $user_pwd, $email, $full_name, $address, $contact)
		{
			$request = $this->dbh->prepare("INSERT INTO kp_user (user_name, user_pwd, email, full_name, address, contact) VALUES(?,?,?,?,?,?) ");

			// Do not forget to encrypt the pasword before saving
			return $request->execute([$user_name, session::hashPassword($user_pwd), $email, $full_name, $address, $contact]);
		}
		/**
		 * Fetch admins
		 */
		
		public function fetchAdmin($limit = 10)
		{
			$request = $this->dbh->prepare("SELECT * FROM kp_user  ORDER BY user_id DESC  LIMIT $limit");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}
		/**
		 * Update Admin
		 */
		public function updateAdmin($id, $user_name, $email, $full_name, $address, $contact)
		{
			$request = $this->dbh->prepare("UPDATE kp_user SET user_name =?, email =?, full_name =?, address= ?, contact =? WHERE user_id =?");
			return $request->execute([$user_name, $email, $full_name, $address, $contact, $id]);
		}



	
		/**
		 * Delete an user
		 */
		public function deleteUser($id)
		{
			$request = $this->dbh->prepare("DELETE FROM kp_user WHERE user_id = ?");
			return $request->execute([$id]);
		}



		/**
	 * Customers RELATED FUNCTIONS ###################################################################################################################
	 */
		
		/**
		 * Create a new row of Customers
		 * 
		 */
		
		public function addCustomer($full_name, $nid, $address, $conn_location, $email, $package, $ip_address, $conn_type, $contact)
		{
			$request = $this->dbh->prepare("INSERT INTO customers (`full_name`, `nid`, `address`, `conn_location`, `email`, `package_id`, `ip_address`, `conn_type`, `contact`) VALUES(?,?,?,?,?,?,?,?,?)");
			// Do not forget to encrypt the pasword before saving
			return $request->execute([$full_name, $nid, $address, $conn_location, $email, $package, $ip_address, $conn_type, $contact]);
		}
		/**
		 * Fetch Customers
		 */
		
		public function fetchCustomer($limit = 10)
		{
			$request = $this->dbh->prepare("SELECT * FROM customers  ORDER BY id DESC  LIMIT $limit");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}
		/**
		 * Update Customers
		 */
		public function updateCustomer($id, $full_name, $nid, $address, $conn_location, $email, $package, $ip_address, $conn_type, $contact)
		{
			$request = $this->dbh->prepare("UPDATE customers SET full_name =?, nid =?, address =?, conn_location= ?, email =?, package_id =?, ip_address=?, conn_type=?, contact=? WHERE id =?");
			return $request->execute([$full_name, $nid, $address, $conn_location, $email, $package, $ip_address, $conn_type, $contact, $id]);
		}



	
		/**
		 * Delete a Customer
		 */
		public function deleteCustomer($id)
		{
			$request = $this->dbh->prepare("DELETE FROM customers WHERE id = ?");
			return $request->execute([$id]);
		}




	/**
	 * Product RELATED FUNCTIONS ###################################################################################################################
	 */
		/**
		 * Create a new row of product
		 * 
		 */
		public function addNewProduct($name, $unit, $details, $category)
		{
			try {
					$request = $this->dbh->prepare("INSERT INTO kp_products (pro_name, pro_unit, pro_details, pro_category) VALUES(?,?,?,?) ");
					return $request->execute([$name, $unit, $details, $category]);
			} catch (Exception $e) {
				return false;
			}
		}


		/**
		 * Check if a  product exists with the same name
		 */
		public function productExists( $pro_name )
		{
			$request = $this->dbh->prepare("SELECT pro_name FROM kp_products WHERE pro_name = ?");
			$request->execute([$pro_name]);
			$Admindata = $request->fetchAll();
			return sizeof($Admindata) != 0;
		}

		/**
		 * Update product
		 */
		public function updateProduct($id, $name, $unit, $details, $category)
		{
			$request = $this->dbh->prepare("UPDATE kp_products SET pro_name = ?, pro_unit = ?, pro_details = ?, pro_category = ? WHERE pro_id = ? ");
			return $request->execute([$name, $unit, $details, $category, $id]);
		}



		/**
		 * Delete a product with id
		 */
		public function deleteProduct($id)
		{
			$request = $this->dbh->prepare("DELETE FROM kp_products WHERE pro_id = ?");
			return $request->execute([$id]);
		}

		/**
		 * Fetch category
		 */
		
		public function fetchCategory()
		{
			$request = $this->dbh->prepare("SELECT cat_name FROM kp_category  ORDER BY cat_id ");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}


		/**
		 * Fetch products all limit of 100
		 */
		
		public function fetchProducts($limit = 100)
		{
			$request = $this->dbh->prepare("SELECT * FROM kp_products ORDER BY pro_id  LIMIT $limit");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}

		/**
		 *	Fetch a Single product
		 */

		public function getAProduct($id)
		{
			$request = $this->dbh->prepare("SELECT * FROM kp_products WHERE pro_id = ?");
			if ($request->execute([$id])) {
				return $request->fetch();
			}
			return false;
		}


		

		/**
		*Fetch production from database
		*/
		public function fetchProduction($limit = 5)
		{
			$request = $this->dbh->prepare("SELECT * FROM product WHERE type=1 ORDER BY id DESC LIMIT $limit");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}
		public function fetchProductionSend($limit = 5)
		{
			$request = $this->dbh->prepare("SELECT * FROM product WHERE type=0 ORDER BY id DESC LIMIT $limit");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}

		public function insertProductData($proselect, $quantity, $date, $provider, $recipient, $remarks, $type)
		{
			try {
					$request = $this->dbh->prepare("INSERT INTO product (product_id, quantity, cdate, provider,recipient,remarks, type) VALUES(?,?,?,?,?,?,?) ");
					return $request->execute([$proselect, $quantity, $date, $provider, $recipient, $remarks, $type]);
			} catch (Exception $e) {
				return false;
			}
		}
		public function deleteProduction($id)
		{
			$request = $this->dbh->prepare("DELETE FROM product WHERE id = ?");
			return $request->execute([$id]);
		}

		/**
		 * production Status
		 */
		 public function fetchProductionStats($limit = 100)
		{
			$request = $this->dbh->prepare("SELECT n.product_id, n .name, IFNULL((n.received-s.sent),n.received) as quantity FROM (SELECT product_id,(SELECT pro_name FROM kp_products where pro_id= product_id) AS name, IFNULL(SUM(quantity),0) as received FROM product WHERE type=1 GROUP BY product_id) n LEFT JOIN (SELECT product_id, IFNULL(SUM(quantity),0) as sent FROM product WHERE type=0 GROUP BY product_id) s ON s.product_id = n.product_id");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}
		
		

		/**
		 * production Status
		 */
		 public function fetchBilling($limit = 100)
		{
			$request = $this->dbh->prepare("SELECT id, customer_id, GROUP_CONCAT(r_month) as months, sum(amount) as total, g_date, p_date, paid FROM payments WHERE paid = 0 Group BY customer_id LIMIT $limit");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}
		 public function fetchindIvidualBill($customer_id)
		{
			$request = $this->dbh->prepare("SELECT * FROM `payments` where customer_id = $customer_id and paid = 0");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}
		
		public function getCustomerInfo($id)
		{
			$request = $this->dbh->prepare("SELECT * FROM customers WHERE id = ?");
			if ($request->execute([$id])) {
				return $request->fetch();
			}
			return false;
		}
		public function getPackageInfo($id)
		{
			$request = $this->dbh->prepare("SELECT * FROM packages WHERE id = ?");
			if ($request->execute([$id])) {
				return $request->fetch();
			}
			return false;
		}

		public function getPackages()
		{
			$request = $this->dbh->prepare("SELECT * FROM packages ORDER BY id");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}

		public function deletePackage($id){
			$request = $this->dbh->prepare("DELETE FROM packages WHERE id = ?");
			return $request->execute([$id]);
		}

		public function updatePackage($id, $name, $price){
			$request = $this->dbh->prepare("UPDATE packages SET name = ?, fee = ? WHERE id = ?");
			return $request->execute([$name, $price, $id]);
		}

		public function addNewPackage($name, $price){
			try {
				$request = $this->dbh->prepare("INSERT INTO packages (name, fee) VALUES(?,?) ");
				return $request->execute([$name, $price]);
			} catch (Exception $e) {
				return false;
			}
		}
		
		/**
		 * Cash Collection
		 */
		 public function fetchCollectin($limit = 100)
		{
			$request = $this->dbh->prepare("SELECT * FROM cash_collection LIMIT $limit");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}
		/**
		 * Cash Expanse
		 */
		 public function fetchExpanse($limit = 100)
		{
			$request = $this->dbh->prepare("SELECT * FROM cash_expanse LIMIT $limit");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}
		
		/**
		* Insert Payment data
		*/
		public function billPay( $customer_id, $bill_id, $bill_months, $discount, $bill_amount )
		{	
			try {
				$this->dbh->beginTransaction();
					$request = $this->dbh->prepare("INSERT INTO billings (customer_id, bill_id, bill_month, discount, bill_amount) VALUES(?,?,?,?,?)");
					$request->execute([$customer_id, $bill_id, $bill_months, $discount, $bill_amount]);

					$values = explode(',', $bill_id);
					$placeholder = rtrim(str_repeat('?, ', count($values)), ', ');

					$request2 = $this->dbh->prepare("UPDATE payments SET paid=1,p_date = NOW() WHERE id IN ($placeholder)");
					$request2->execute($values);
				$this->dbh->commit();
				return true;
			} catch (Exception $e) {
				$this->dbh->rollBack();
				return false;
			}
		}
		


	// Bill generation of a Month
		public function billGenerate($customer_id, $r_month, $amount){
			try {
				$request = $this->dbh->prepare("INSERT IGNORE INTO payments (customer_id, r_month, amount) VALUES(?,?,?)");
				return $request->execute([$customer_id, $r_month, $amount]);
			} catch (Exception $e) {
				return false;
			}
		}
		public function getLastMonth($customer_id){
			$request = $this->dbh->prepare("SELECT r_month FROM payments WHERE customer_id = ? LIMIT 1");
			if ($request->execute([$customer_id])) {
				return $request->fetch();
			}
			return false;
		}
		public function fetchActiveCustomers(){
			$request = $this->dbh->prepare("SELECT * FROM `customers` where dropped = 0 ORDER BY id");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}




		public function	fetchPaymentSlip($customer_id){
			$request = $this->dbh->prepare("SELECT * FROM `billings` where customer_id = ? LIMIT 1");
			if ($request->execute([$customer_id])) {
				return $request->fetch();
			}
			return false;
		}


	//Expance related functions
		public function expanse($amount, $for, $remarks){
			try {
				$request = $this->dbh->prepare("INSERT INTO cash_expanse (amount, purpose, remarks) VALUES(?,?,?)");
				return $request->execute([$amount, $for, $remarks]);
			} catch (Exception $e) {
				return false;
			}
		}
	//Collection related functions
		public function colleciton($amount, $from, $remarks){
			try {
				$request = $this->dbh->prepare("INSERT INTO cash_collection (amount, payee, remarks) VALUES(?,?,?)");
				return $request->execute([$amount, $from, $remarks]);
			} catch (Exception $e) {
				return false;
			}
		}




		public function getCategories()
		{
			$request = $this->dbh->prepare("SELECT * FROM kp_category ORDER BY cat_id");
			if ($request->execute()) {
				return $request->fetchAll();
			}
			return false;
		}

		public function deleteCategory($id){
			$request = $this->dbh->prepare("DELETE FROM kp_category WHERE cat_id = ?");
			return $request->execute([$id]);
		}

		public function updateCategory($id, $name){
			$request = $this->dbh->prepare("UPDATE kp_category SET cat_name = ? WHERE cat_id = ?");
			return $request->execute([$name, $id]);
		}

		public function addNewCategory($name){
			try {
				$request = $this->dbh->prepare("INSERT INTO kp_category (cat_name) VALUES(?) ");
				return $request->execute([$name]);
			} catch (Exception $e) {
				return false;
			}
		}



	// commented
		// /**
		//  * Raw Products
		//  */
		// public function addRawProduct($name, $unit, $details)
		// {
		// 	$request = $this->dbh->prepare("INSERT INTO kp_raw (raw_name, raw_unit, raw_details) VALUES(?,?,?) ");

		// 	return $request->execute([$name, $unit, $details]);
		// }

		// /**
		//  * Check if a raw product exist
		//  */
		// public function rawproductExists( $raw_name )
		// {
		// 	$request = $this->dbh->prepare("SELECT raw_name FROM kp_raw WHERE raw_name = ?");
		// 	$request->execute([$raw_name]);
		// 	$Admindata = $request->fetchAll();
		// 	return sizeof($Admindata) != 0;
		// }

		// /**
		//  * Edit a product
		//  */

		// public function updateRawProduct($id, $name, $unit, $details)
		// {
		// 	$request = $this->dbh->prepare("UPDATE kp_raw SET raw_name = ?, raw_unit = ?, raw_details = ? WHERE raw_id = ? ");

		// 	// Do not forget to encrypt the pasword before saving
		// 	return $request->execute([$name, $unit, $details, $id]);
		// }




		/**
		 * Fetch products
		 */
		
		// public function fetchChartData()
		// {
		// 	$request = $this->dbh->prepare("SELECT pro_id, raw_quantity FROM kp_raw  ORDER BY raw_id");
		// 	if ($request->execute()) {
		// 		return $request->fetchAll();
		// 	}
		// 	return false;
		// }



		// /**
		//  * Fetch raw products
		//  */
		// public function fetchrawProducts($limit = 100)
		// {
		// 	$request = $this->dbh->prepare("SELECT * FROM kp_raw  ORDER BY raw_id  LIMIT $limit");
		// 	if ($request->execute()) {
		// 		return $request->fetchAll();
		// 	}
		// 	return false;
		// }



		// /**
		//  *	Fetch a raw product
		//  */

		// public function getArawProduct($id)
		// {
		// 	$request = $this->dbh->prepare("SELECT * FROM kp_raw WHERE raw_id = ?");
		// 	if ($request->execute([$id])) {
		// 		return $request->fetch();
		// 	}
		// 	return false;
		// }



		/*
		 *	Delete a raw product
		 */

		// public function deleterawProduct($id)
		// {
		// 	$request = $this->dbh->prepare("DELETE FROM kp_raw WHERE raw_id = ?");
		// 	return $request->execute([$id]);
		// }

		// /**
		// * Insert product data
		// */
		// public function insertProductData( $proselect, $production, $date, $finished, $unfinished )
		// {
		// 	try {
		// 		$this->dbh->beginTransaction();
		// 			$request = $this->dbh->prepare("INSERT INTO kp_production (pro_id, pro_qty, date, pro_fin, pro_unfin) VALUES(?,?,?,?,?)");
		// 			$request->execute([$proselect, $production, $date, $finished, $unfinished]);

		// 			$request2 = $this->dbh->prepare("UPDATE pro_finished SET pro_qty = pro_qty+? WHERE pro_id = ?");
		// 			$request2->execute([$finished, $proselect]);

		// 			$request3 = $this->dbh->prepare("UPDATE pro_unfinished SET pro_qty = pro_qty+? WHERE pro_id = ?");
		// 			$request3->execute([$unfinished, $proselect]);
		// 		$this->dbh->commit();
		// 		return true;
		// 	} catch (Exception $e) {
		// 		$this->dbh->rollBack();
		// 		return false;
		// 	}
		// }
		/*
		 *	Delete a raw product
		 */

		// public function deleteProduction($id)
		// {
		// 	try {
		// 			// $this->dbh->beginTransaction();
		// 			// $request1 = $this->dbh->prepare("SELECT id, pro_id, pro_qty FROM kp_production WHERE id = ?");
		// 			// $request1->execute([$id]);
		// 			// $request1->fetch(PDO::FETCH_CLASS,'Admin');
		// 			// $quantity = $this->request1->pro_qty;
		// 			// $pro_id = $this->request1->pro_id;

		// 			// $request2 = $this->dbh->prepare("UPDATE pro_finished SET pro_qty = (pro_qty-?) WHERE pro_id = ?");
		// 			// $request2->execute([$quantity, $pro_id]);

		// 			$request = $this->dbh->prepare("DELETE FROM kp_production WHERE id = ?");
		// 			$request->execute([$id]);
		// 			// $this->dbh->commit();
		// 		return true;
		// 	} catch (Exception $e) {
		// 		//$this->dbh->rollBack();
		// 		return false;
		// 	}
		// }

		// /**
		// * Insert Raw data stat
		// */
		// public function insertRawData($raw_id, $date, $used, $purchased, $available)
		// {
		// 	try {
		// 		$this->dbh->beginTransaction();
		// 			$request = $this->dbh->prepare("INSERT INTO raw_stocking (raw_id, date, raw_purchesed, raw_used ) VALUES(?,?,?,?)");
		// 			$request->execute([$raw_id, $date, $purchased, $used]);

		// 			$request2 = $this->dbh->prepare("UPDATE kp_raw SET raw_quantity = raw_quantity+? WHERE raw_id = ?");
		// 			$request2->execute([$available, $raw_id]);
		// 		$this->dbh->commit();
		// 		return true;
		// 	} catch (Exception $e) {
		// 		$this->dbh->rollBack();
		// 		return false;
		// 	}
		// }

		/*
		 *	Delete a raw product
		 */

		// public function deleteRawData($id)
		// {
		// 	try {
		// 			// $this->dbh->beginTransaction();
		// 			// $request1 = $this->dbh->prepare("SELECT id, pro_id, pro_qty FROM kp_production WHERE id = ?");
		// 			// $request1->execute([$id]);
		// 			// $request1->fetch(PDO::FETCH_CLASS,'Admin');
		// 			// $quantity = $this->request1->pro_qty;
		// 			// $pro_id = $this->request1->pro_id;

		// 			// $request2 = $this->dbh->prepare("UPDATE pro_finished SET pro_qty = (pro_qty-?) WHERE pro_id = ?");
		// 			// $request2->execute([$quantity, $pro_id]);

		// 			$request = $this->dbh->prepare("DELETE FROM raw_stocking WHERE id = ?");
		// 			$request->execute([$id]);
		// 			// $this->dbh->commit();
		// 		return true;
		// 	} catch (Exception $e) {
		// 		//$this->dbh->rollBack();
		// 		return false;
		// 	}
		// }


		// /*production to stocking table*/
		// public function insertProductionData( $proselect, $sold, $date, $waste, $return )
		// {	
		// 	$availableProducts = ($sold+$waste)-$return;
		// 	try {
		// 		$this->dbh->beginTransaction();
		// 			$request = $this->dbh->prepare("INSERT INTO kp_stocking (pro_id, date, pro_sold, pro_waste, pro_return) VALUES(?,?,?,?,?)");
		// 			$request->execute([$proselect, $date, $sold, $waste, $return]);

		// 			$request2 = $this->dbh->prepare("UPDATE pro_finished SET pro_qty = pro_qty-? WHERE pro_id = ?");
		// 			$request2->execute([$availableProducts, $proselect]);

		// 		$this->dbh->commit();
		// 		return true;
		// 	} catch (Exception $e) {
		// 		$this->dbh->rollBack();
		// 		return false;
		// 	}
		// }


		/*
		 *	Delete a raw product
		 */

		// public function deleteStocking($id)
		// {
		// 	try {
		// 			// $this->dbh->beginTransaction();
		// 			// $request1 = $this->dbh->prepare("SELECT id, pro_id, pro_qty FROM kp_production WHERE id = ?");
		// 			// $request1->execute([$id]);
		// 			// $request1->fetch(PDO::FETCH_CLASS,'Admin');
		// 			// $quantity = $this->request1->pro_qty;
		// 			// $pro_id = $this->request1->pro_id;

		// 			// $request2 = $this->dbh->prepare("UPDATE pro_finished SET pro_qty = (pro_qty-?) WHERE pro_id = ?");
		// 			// $request2->execute([$quantity, $pro_id]);

		// 			$request = $this->dbh->prepare("DELETE FROM kp_stocking WHERE id = ?");
		// 			$request->execute([$id]);
		// 			// $this->dbh->commit();
		// 		return true;
		// 	} catch (Exception $e) {
		// 		//$this->dbh->rollBack();
		// 		return false;
		// 	}
		// }

		/*
		*Fetch production from database
		*/
		// public function fetchProduction($limit = 100)
		// {
		// 	$request = $this->dbh->prepare("SELECT * FROM kp_production  ORDER BY id DESC LIMIT $limit");
		// 	if ($request->execute()) {
		// 		return $request->fetchAll();
		// 	}
		// 	return false;
		// }

		// /**
		// *Get list of finished products
		// */
		// public function getfinishedProduct($id)
		// {
		// 		$request = $this->dbh->prepare("SELECT * FROM pro_finished WHERE pro_id = ?");
		// 		if ($request->execute([$id])) {
		// 			return $request->fetch();
		// 		}
		// 		return false;
		// }

		// /**
		// * Get list of unfinished products
		// *
		// */
		// public function getunfinishedProduct($id)
		// {
		// 		$request = $this->dbh->prepare("SELECT * FROM pro_unfinished WHERE pro_id = ?");
		// 		if ($request->execute([$id])) {
		// 			return $request->fetch();
		// 		}
		// 		return false;
		// }

		/*
		*	Fetch production from database
		*/
		// public function fetchProductionData($limit = 100)
		// {
		// 	$request = $this->dbh->prepare("SELECT * FROM kp_stocking  ORDER BY id DESC LIMIT $limit");
		// 	if ($request->execute()) {
		// 		return $request->fetchAll();
		// 	}
		// 	return false;
		// }


		// /**
		//  * Fetch raw products
		//  */
		// public function fetchrawEntry($limit = 100)
		// {
		// 	$request = $this->dbh->prepare("SELECT * FROM raw_stocking  ORDER BY id  LIMIT $limit");
		// 	if ($request->execute()) {
		// 		return $request->fetchAll();
		// 	}
		// 	return false;
		// }

	}

