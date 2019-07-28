<?php 

  function get($tableName,$byArray = null)
  {
      global $conn;
      if ($byArray == null) {
          $query = sprintf('select * from %s',$tableName);
           $stmt = $conn->query( $query );
           $rowsCount = $stmt->rowcount();
           $stmt->setFetchMode(PDO::FETCH_ASSOC);
           if ($rowsCount > 0) {
               $data = [];
               foreach ($stmt as $key) {
                   $data[] = $key;
               }
               return $data;
           }
           else{
               return false;
           }
      }
      else{

          $by = '';
            foreach ($byArray as $col => $value) {

                $by .= sprintf("`%s`='%s' AND ", $col,$value);
            }
           $by =  substr($by, 0,-4);
          $query = sprintf('select * from %s where %s',$tableName,$by);

           $stmt        = $conn->query( $query );
           $rowsCount = $stmt->rowcount();
           $stmt->setFetchMode(PDO::FETCH_ASSOC);
           if ($rowsCount > 0) {
               $data = [];
               foreach ($stmt as $key) {
                   $data[] = $key;
               }
               return $data;
           }
           else{
               return false;
           }
      }
  }

  function insert($table,$data,$return = null){
      global $conn;

      $fields = '';
       $values = '';
       foreach($data as $col => $value){
           $fields .= sprintf("`%s`,", $col);
           $values .= sprintf("'%s',",$value);
       }
       $fields = substr($fields, 0, -1);
       $values = substr($values, 0, -1);
       $query  = sprintf("INSERT INTO %s (%s) VALUES (%s)", $table, $fields, $values);
       // echo $query;
       $stmt   = $conn->prepare( $query );
       $result = $stmt->execute();
       $lastId = $conn->lastInsertId();

       if ($return != null) {
           $status = $lastId;
       }
       else{
           $status = true;
       }
       $lastId = $conn->lastInsertId();

       if ($result == true) {
           return $status;
       }
       else{
           return false;
       }
  }

  function update($table, $valuesArray,$byArray){
       global $conn;
       $update = '';
       foreach($valuesArray as $col => $value){
           $update .= sprintf("`%s`='%s', ", $col,$value);
       }
       $update = substr($update, 0,-2);
       $by = '';
        foreach ($byArray as $col => $value) {

            $by .= sprintf("%s='%s' AND ", $col,$value);
        }
       $by =  substr($by, 0,-4);


       $query  = sprintf("UPDATE %s SET %s where %s", $table, $update,$by);
    
      
       $stmt   = $conn->prepare( $query );
       $result = $stmt->execute();
       if ($result) {
           return true;
       }
       else{
           return false;
       }
   }

function delete($table,$byArray){
       global $conn;
       $by = '';
        foreach ($byArray as $col => $value) {

            $by .= sprintf("`%s`='%s' AND ", $col,$value);
        }
       $by =  substr($by, 0,-4);

       $query = sprintf("DELETE FROM %s where %s", $table,$by);

       $stmt     = $conn->prepare( $query );
       $result = $stmt->execute();
       if ($result) {
           return true;
       }
       else{
           return false;
       }
   }


 ?>