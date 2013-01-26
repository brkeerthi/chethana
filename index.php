<?php
  include_once 'WolframAlphaEngine.php';
?>
<html>
<head>
	<title>Chethana</title>
	
  <script type="text/javascript" src="jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="jquery.mobile-1.1.0.min.js"></script>
    
	<link rel="stylesheet" href="jquery.mobile-1.1.0.min.css" />
	
</head>
<body>
<!-- Start of Home page -->
<div data-role="page" id="home">

	<div data-role="header">
	
		<p align="center"> <img src="logo.png" /> </p>
	
		<div data-role="navbar">
			
		</div>
	</div>

	<div data-role="content">
	<form method="get" action="#"> <p align="center">
<table bgcolor="" cellpadding="0px" cellspacing="0px">
<tr>
<td style="border-style:none;">
 <input type="text" name="q" value="" autocomplete="on" autofocus="autofocus" id="track_id" placeholder="Ask Chethana"/>
</div>
</td>
<td style="border-style:none;"> 
<button data-role="submit" value="" id="">search</button>

</div>
</td>
</tr>
</table>
</form> </p>

<br><br>     
<hr>
<?php
  $appID = 'A7UT2J-Y2PR75RKW3';

  // instantiate an engine object with your app id
  $engine = new WolframAlphaEngine( $appID );

  // we will construct a basic query to the api with the input 'pi'
  // only the bare minimum will be used
  $response = $engine->getResults( $_REQUEST['q'] );

  // getResults will send back a WAResponse object
  // this object has a parsed version of the wolfram alpha response
  // as well as the raw xml ($response->rawXML) 
  
  // we can check if there was an error from the response object
  if ( $response->isError ) {
?>
  <h1>There was an error in the request</h1>
  </body>
  </html>
<?php
    die();
  }
?>
 
<br>

<?php
  // if there are any assumptions, display them 
  if ( count($response->getAssumptions()) > 0 ) {
?>
    <h2>Assumptions:</h2>
    <ul>
<?php
      // assumptions come as a hash of type as key and array of assumptions as value
      foreach ( $response->getAssumptions() as $type => $assumptions ) {
?>
        <li><?php echo $type; ?>:<br>
          <ol>
<?php
          foreach ( $assumptions as $assumption ) {
?>
            <li><?php echo $assumption->name ." ". $assumption->description;?> to change search to this assumption <a href="index.php?q=<?php echo urlencode($assumption->input);?>">click here</a></li>
<?php
          }
?>
          </ol>
        </li>
<?php
      }
?>
      
    </ul>
<?php
  }
?>

<hr>
 
<?php
  // if there are any pods, display them
  if ( count($response->getPods()) > 0 ) {
?>

    <h2>chethana answers</h2>
    <table border=1 width="80%" align="center">
<?php
    foreach ( $response->getPods() as $pod ) {
?>
      <tr>
        <td>
          <h3><?php echo $pod->attributes['title']; ?></h3>
<?php
        // each pod can contain multiple sub pods but must have at least one
        foreach ( $pod->getSubpods() as $subpod ) {
          // if format is an image, the subpod will contain a WAImage object
?>
          <img src="<?php echo $subpod->image->attributes['src']; ?>">
          <hr>
<?php
        }
?>
          
        </td>
      </tr>
<?php
    }
?>
    </table>
<?php
  }
?>


	</div>



<!-- End of Home page -->

	<footer>
		
	<p align="center" <p>Copyright &copy;2013</p>
		
		</footer>

</div>
<!-- End of Home page -->

</body>
</html>