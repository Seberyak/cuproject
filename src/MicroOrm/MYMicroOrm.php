<?php

    $link = mysqli_connect("localhost","root","","PHPLearning");
    $table="users";

    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }


    //prametrad gadaecema masivis 0-2 usrname,password,address, danarcheni logikisaa, ver vaswreb agweras... :d
    $params=array("id" => "","username" => "", "password" => "", "logic_param"=>"" , "expression"=>"");

    //insert($table,$params);




        function  insert($table, $params){
            global $link;
            $id=$params['id'];
            $username=$params['username'];
            $password=$params['password'];

            mysqli_query($link, "INSERT INTO users (id,username,password)
             VALUES ('$id','$username','$password')");
            }



        //am params-shi gadavcemt asocirebul masivs
        function  select($table, $params){
            global $link;
            mysqli_query($link, "SELECT * FROM users WHERE id like params['id']" );

        }



        function  delete($table, $params){
            global $link;
            $username=$params['username'];
            $id=$params['id'];

            mysqli_query($link,"DELETE FROM users WHERE username like '$username' or id = '$id' ");

        }


        function  update($table, $params){
            global $link;
            $username=$params['username'];
            $logic_param=params['logic_param'];
            $expression=params['expression'];
            mysqli_query($link, "UPDATE users SET $logic_param = '$expression' ");
        }



         $result = mysqli_query($link, "SELECT * FROM users");
    while ($row = $result->fetch_assoc()) {
      //  print_r(json_encode($row));
      foreach ($row as $key => $value) {
        print($key.' : '.$value."<br>");
      }
      print("<br>");
    }




        ?>
