<?php include("../../core/session.php");

if($session->logged_in){

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>PhantaC ShoutBox</title>
  <style type="text/css">
    #daddy-shoutbox {
      padding: 5px;
      background: #3E5468;
      color: white;
      width: 600px;
      font-family: Arial,Helvetica,sans-serif;
      font-size: 11px;
    }
    .shoutbox-list {
      border-bottom: 1px solid #627C98;
      
      padding: 5px;
      display: none;
    }
    #daddy-shoutbox-list {
      text-align: left;
      margin: 0px auto;
    }
    #daddy-shoutbox-form {
      text-align: left;
      
    }
    .shoutbox-list-time {
      color: #8DA2B4;
    }
    .shoutbox-list-nick {
      margin-left: 5px;
      font-weight: bold;
    }
    .shoutbox-list-message {
      margin-left: 5px;
    }

    #container{
         width:400px;
         margin:0px auto;
         padding:40px 0;
     }
      #scrollbox{
          width:500px;
          height:300px;
          overflow:auto; overflow-x:hidden;
      }
       #container > p{
           background:#eee;
           color:#666;
           font-family:Arial, sans-serif; font-size:0.75em;
           padding:5px; margin:0;
           text-align:right;
       }
    
  </style>
  
  <script type="text/javascript" src="javascript/jquery.js"></script>
  <script type="text/javascript" src="javascript/jquery.form.js"></script>
  
</head>
  <body>

  <center>

    <div id="daddy-shoutbox">
    <div id="daddy-shoutbox-list"></div>
    <br />
    <form id="daddy-shoutbox-form" action="daddy-shoutbox.php?action=add" method="post"> 
    <input type="text" name="nickname" value="<? echo $session->username ?>" readonly/> Say: <input type="text" name="message" />

    <input type="submit" value="Submit" />
    <span id="daddy-shoutbox-response"></span>
    </form>
        </div>
     <p><span id="status" ></span></p>
  </center>

  
  <script type="text/javascript">
          $('document').ready(function(){
        updatestatus();
        scrollalert();
    });
    function updatestatus(){
       //Show number of loaded items
       var totalItems=$('#content p').length;
       // $('#status').text('Loaded '+totalItems+' Items');
    }
   function scrollalert(){
       var scrolltop=$('#scrollbox').attr('scrollTop');
       var scrollheight=$('#scrollbox').attr('scrollHeight');
       var windowheight=$('#scrollbox').attr('clientHeight');
       var scrolloffset=20;
       if(scrolltop>=(scrollheight-(windowheight+scrolloffset)))
       {
           //fetch new items
           $('#status').text('Loading more items...');
           $.get('new-items.html', '', function(newitems){
               $('#content').append(newitems);
               updatestatus();
           });
       }
       setTimeout('scrollalert();', 1500);
   } 
        var count = 0;
        var files = '';
        var lastTime = 0;
        
        function prepare(response) {
          var d = new Date();
          count++;
          d.setTime(response.time*1000);
          var mytime = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
          var string = '<div class="shoutbox-list" id="list-'+count+'">'
              + '<span class="shoutbox-list-time">'+mytime+'</span>'
              + '<span class="shoutbox-list-nick">'+response.nickname+':</span>'
              + '<span class="shoutbox-list-message">'+response.message+'</span>'
              +'</div>';
          
          return string;
        }
        
        function success(response, status)  { 
          if(status == 'success') {
            lastTime = response.time;
            $('#daddy-shoutbox-response').html('<img src="'+files+'images/accept.png" />');
            $('#daddy-shoutbox-list').append(prepare(response));
            $('input[@name=message]').attr('value', '').focus();
            $('#list-'+count).fadeIn('slow');
            timeoutID = setTimeout(refresh, 3000);
          }
        }
        
        function validate(formData, jqForm, options) {
          for (var i=0; i < formData.length; i++) { 
              if (!formData[i].value) {
                  alert('Please fill in all the fields'); 
                  $('input[@name='+formData[i].name+']').css('background', 'red');
                  return false; 
              } 
          } 
          $('#daddy-shoutbox-response').html('<img src="'+files+'images/loader.gif" />');
          clearTimeout(timeoutID);
        }

        function refresh() {
          $.getJSON(files+"daddy-shoutbox.php?action=view&time="+lastTime, function(json) {
            if(json.length) {
              for(i=0; i < json.length; i++) {
                $('#daddy-shoutbox-list').append(prepare(json[i]));
                $('#list-' + count).fadeIn('slow');
              }
              var j = i-1;
              lastTime = json[j].time;
            }
            //alert(lastTime);
          });
          timeoutID = setTimeout(refresh, 3000);
        }
        
        // wait for the DOM to be loaded 
        $(document).ready(function() { 
            var options = { 
              dataType:       'json',
              beforeSubmit:   validate,
              success:        success
            }; 
            $('#daddy-shoutbox-form').ajaxForm(options);
            timeoutID = setTimeout(refresh, 100);
        });
  </script>
</body>
</html>
<?php
} else{
    Header("Location: index.php");
}
?>