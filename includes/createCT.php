<?php
class createCT {
    
    public function __construct()
	{ 
        $options = get_option( 'scwpec_options' );
            $servername = $options['host'];
            $username = $options['dbuser'];
            $password = $options['dbpassword'];
            $dbase = $options['dbase'];
            $table = $options['tcustomers'];
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbase", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "CREATE TABLE IF NOT EXISTS $table(
                        `metaid` bigint(11) NOT NULL,
                        `name` text NOT NULL,
                        `email` text NOT NULL,
                        `shipping_name` text NOT NULL,
                        `house_number` text NOT NULL,
                        `street` text NOT NULL,
                        `city` text NOT NULL,
                        `county` text NOT NULL,
                        `zip` text NOT NULL,
                        `country` text NOT NULL,
                        `telephone` text NOT NULL
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