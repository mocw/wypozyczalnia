<?php
if(isset($_SESSION['uID']) && $_SESSION['isRoot']==1){
    echo '
    <center><nav>
  <UL class="root">
   <li class="var_nav">
      <div class="link_bg"></div>
      <div class="link_title">
        <div class=icon> 
        <i class=""></i>
        </div>
        <a class="root" href="index.php?action=uprawnienia"><span class="root">Uprawnienia</span></a>
      </div>
   </li>
   <li class="var_nav">
      <div class="link_bg"></div>
      <div class="link_title">
        <div class=icon> 
        <i class=""></i>
        </div>
        <a class="root" href="#"><span class="root">Dodaj pracownika</span></a>
      </div>
   </li>
  </UL>
</nav></center>
    ';
} else header('Location: index.php?action=home');

?>
