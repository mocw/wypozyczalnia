<?php
$marka="Ford";
$model="Fiesta";
$silnik="1.2";
$test=$marka."&#xa;".$model."&#xa;".$silnik;
//"Ford&#xa; Fiesta&#xa; 1.2"
?>
<div class="box">
<div class="demo">
<form method="POST" action="index.php?action=carreserv">
<ul class="list">
  <li class="list-item">
    <div class="list-content">
      <center>
        <button data-html="true" data-tooltip=<?php echo $test?> name="car" class="offerbtn" value="car1">
        <img src="images/car2.png" alt="" action="index.php?action=register" />
      </button>
    </center>
    </div>
  </li>
	
	 <li class="list-item">
    <div class="list-content">
       <center>   
       <button data-tooltip=<?php echo $test?> name="car" class="offerbtn" value="car2">      
         <img src="images/car2.png" alt="" />
</button>
        </center>
    </div>
  </li>
  
  <li  class="list-item">
    <div class="list-content">
    <center>
    <button data-tooltip=<?php echo $test?> name="car" class="offerbtn" value="car3">
      <img src="images/car3.png" alt="" />
    </button>
    </center>
    </div>
  </li>
  
  <li class="list-item">
    <div class="list-content">
      <center>
      <button data-tooltip=<?php echo $test?> name="car" class="offerbtn" value="car4">
        <img src="images/car3.png" alt="" />
      </button>
      </center>
    </div>
  </li>
  
  <li class="list-item">
    <div class="list-content">
      <center>
      <button data-tooltip=<?php echo $test?> name="car" class="offerbtn" value="car5">
        <img src="images/car5.png" alt="" />
</button>
      </center>
    </div>
  </li>

  <li class="list-item">
    <div class="list-content">
      <center>
      <button data-tooltip=<?php echo $test?> name="car" class="offerbtn" value="car6">
        <img src="images/car5.png" alt="" />
      </button>
      </center>
    </div>
  </li>

  <li class="list-item">
    <div class="list-content">
      <center>
      <button data-tooltip=<?php echo $test?> name="car" class="offerbtn" value="car7">
        <img src="images/car5.png" alt="" />
</button>
      </center>
    </div>
  </li>

  <li class="list-item">
    <div class="list-content">
      <center>
      <button data-tooltip=<?php echo $test?> name="car" class="offerbtn" value="car8">
        <img src="images/car5.png" alt="" />
</button>
      </center>
    </div>
  </li>

  
    <li class="list-item">
    <div class="list-content">
      <center>
      <button data-tooltip=<?php echo $test?> name="car" class="offerbtn" value="car9">
        <img src="images/car5.png" alt="" />
</button>
      </center>
    </div>
  </li>
</ul>
</form>
</div>
</div>