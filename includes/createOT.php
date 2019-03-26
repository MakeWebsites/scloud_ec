<?php
class createOT {
    
    public function __construct()
	{ 
        $options = get_option( 'scwpec_options' );
            $servername = $options['host'];
            $username = $options['dbuser'];
            $password = $options['dbpassword'];
            $dbase = $options['dbase'];
            $table = $options['torders'];
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbase", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE TABLE IF NOT EXISTS $table(
                        `metaid` bigint(20) NOT NULL,
                        `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                        `order_number` text NOT NULL,
                        `customer_db` text NOT NULL,
                        `customer_id` bigint(20) NOT NULL,
                        `variant` enum('BBELight','BBELightWB','BBE','BBEWB','BBELightVic','BBELightBassg','BBEWBX','BBEWBV2','BBERTC','BBEAC','BBEI') DEFAULT NULL,
                        `quantity` int(11) NOT NULL,
                        `shipped_date` timestamp NULL DEFAULT NULL,
                        `quantity_shipped` bigint(20) NOT NULL,
                        `next_part_ship` bigint(20) DEFAULT NULL,
                        `courier` text NOT NULL,
                        `tracking_no` text NOT NULL,
                        `shipping_currency` enum('£','$') NOT NULL,
                        `shipping_cost` float NOT NULL,
                        `invoice_total` decimal(10,2) DEFAULT NULL
                      )" ;
            $conn->exec($sql);
            echo "Table $table - Created!<br /><br />";
        } 
        catch(PDOException $e) {
            echo $e->getMessage();
        }
        
       $conn->null;
        } 
} 