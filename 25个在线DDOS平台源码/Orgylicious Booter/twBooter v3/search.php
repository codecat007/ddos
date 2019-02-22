<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'twbooter';

mysql_connect($host, $user, $pass);
mysql_select_db($db);

$input = mysql_real_escape_string($_POST['search']);
if(!empty($input)){
    $query = mysql_query("SELECT * FROM `users` WHERE username LIKE '%".$input."%' OR email LIKE '%".$input."%' OR payment LIKE '%".$input."%' OR trans LIKE '%".$input."%' OR other LIKE '%".$input."%'")or die(mysql_error());
    if(mysql_num_rows($query) < 1){
        echo 'no results found';
    } else {
        
        ?>
        <table width="100%">
    <tr>
        <td><strong>Username</strong></td>
        <td><strong>E-mail</strong></td>
        <td><strong>Paid</strong></td>
        <td><strong>Trans ID</strong></td>
        <td><strong>Remaining</strong></td>
        <td><strong>Other</strong></td>
        <td><strong>Select</strong></td>
    </tr>
   <?php while($result = mysql_fetch_assoc($query)){ ?>
    <tr>
        <td><a id="<?php echo $result['id'];?>" onclick="
        $('.searchUserInfo').dialog({   
        modal: true,
        draggable: false,
        resizable: false,
        width: '600',
        minHeight: '400'
        });
        $('.searchUserInfo').html('lemme know when u made the DB stuff, I will add the design here.');
   
   
   " class="searchUser" href="javascript: ;"><?php echo $result['username']; ?></a></td>
        <td><?php echo $result['email']; ?></td>
        <td><?php echo $result['payment']; ?></td>
        <td><?php echo $result['trans']; ?></td>
        <td><?php echo $result['date']; ?></td>
        <td><?php echo $result['other']; ?></td>
        <td align="center"><input name="delete" type="checkbox"/></td>
    </tr> 
    
         <?php
         
        } ?></table> <input type="submit" value="Remove Selected"/><?php   
    }
} else{
    echo 'Enter something, phaggot';
}

/*if($input == 'a'){
    echo 'General';
}

elseif($input == 'as'){
    echo 'Tomorrow';
}

elseif($input == 'asd'){
    echo 'today';
}
else {
    echo 'no results';
}*/