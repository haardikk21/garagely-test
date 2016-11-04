<html>
    <body>
        <table>
            <tr>
                <th>Employee Name</th>
                <th>Employee Code</th>
                <th>Employee Gender</th>
             </tr>
        <?php
            $host = 'localhost:8889';
            $user = 'root';
            $pass = 'root';
            $db = 'employees';   
            
            $conn = mysql_connect($host, $user, $pass);
            if(!$conn) {
                die("Could not connect to MySQL Server: " . mysql_error());
            }     
            
            mysql_select_db($db);
            
            $query = "SELECT count(Name) FROM employeetable";
            $sql = mysql_query($query, $conn);
            
            if(!$sql) {
                die("Could not receive data: " . mysql_error());
            }
            
            $rows = mysql_fetch_array($sql, MYSQL_NUM);
            $records = $rows[0];
            $recordslimit = 2;
            
            if(isset($_GET['page']))
            {
                $page = $_GET['page'] + 1;
                $offset = $recordslimit * $page; 
            }
            else {
                $page = 0;
                $offset = 0;
            }
            
            $records_left = $records - $offset;
            $query = "SELECT Name, Code, Gender FROM employeetable " .
                        "LIMIT $offset, $recordslimit";
            $sql = mysql_query($query, $conn);
            
            if(!$sql) {
                die("Could not receive data: " . mysql_error());
            }
            while($row = mysql_fetch_array($sql, MYSQL_ASSOC))
            {
                echo "<tr><td>";
                echo $row['Name'];
                echo "</td><td>";
                echo $row['Code'];
                echo "</td><td>";
                echo $row['Gender'];
                echo "</td></tr>";
            }
            echo "</table>";
            if($page > 0) {
                $last = $page - 2;
                echo "<a href= \"$_PHP_SELF?page=$last\" style='float:left;'>Prev Page</a>";
                echo "<a href= \"$_PHP_SELF?page=$page\" style='float:right;'>Next Page</a>";
            }
            else if ($page == 0)
            {
                echo "<a href= \"$_PHP_SELF?page=$page\" style='float:right;'>Next Page</a>";
            }
            else if($records_left < $recordslimit)
            {
                $last = $page-2;
                echo "<a href= \"$_PHP_SELF?page=$last\" style='float:left;'>Prev Page</a>";
            }
        ?>
        </body>
      </html>