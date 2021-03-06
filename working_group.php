<?php
$showchildren = "n";
$showsiblings = "n";
$titleoverride = "";
include("./inc/head.php");


?>

<div id="page_body" class="row">
	<div class='col-sm-9'>
  <h2><?=$page->title; ?></h2>
		<span class='bodytext'><?=$page->body; ?> </span>
    
    
    <?
    if($page->body_secondary) { ?>
    <h3>Goals</h3>
		<span class='bodytext'><?=$page->body_secondary; ?> </span>
    <? } ?>
    
    
    <?
    
    
    $wg_subgroups      = $pages->get("has_parent={$page->id}, template=working_group_subgroups");
    $wg_projects       = $pages->get("has_parent={$page->id}, template=working_group_projects");
    $wg_taskteams       = $pages->get("has_parent={$page->id}, template=working_group_taskteams");
    
    ?>
    <?php
           if(count($wg_subgroups)) {;
             echo "<h3>Sub Groups</h3>
             <ul class='list-icon icon-arrow-right'>";
                foreach($wg_subgroups->children as $child) {
                     if($child->summary) {
		                  $summary = $sanitizer->text($child->summary);
                    } else {
		                  $summary = $sanitizer->text($child->body);
                    }
                    if(!$summary) {
                      $summary = "Additional information about ".$child->title." available by clicking the link <a href='".$child->url."'>here</a>.";
                    }
		                $summary = (strlen($summary) > 255) ? substr($summary,0,250).'...' : $summary;
                   echo "<li class=' text-muted'><a class='' href='{$child->url}'>{$child->title}</a><br>{$summary}</li>";
                }		
              echo "</ul></li>";
           }
           if(count($wg_taskteams)) {;
             echo "<h3>Task Teams</h3>
             <ul class='list-icon icon-arrow-right'>";
                foreach($wg_taskteams->children as $child) {
                     if($child->summary) {
		                  $summary = $sanitizer->text($child->summary);
                    } else {
		                  $summary = $sanitizer->text($child->body);
                    }
                    if(!$summary) {
                      $summary = "Additional information about ".$child->title." available by clicking the link <a href='".$child->url."'>here</a>.";
                    }
		                $summary = (strlen($summary) > 255) ? substr($summary,0,250).'...' : $summary;
                   echo "<li class=' text-muted'><a class='' href='{$child->url}'>{$child->title}</a><br>{$summary}</li>";
                }		
              echo "</ul></li>";
           }
           if(count($wg_projects)) {;
             echo "<h3>Initiatives &amp; Updates</h3>
             <ul class='list-icon icon-arrow-right'>";
                foreach($wg_projects->children as $child) {
                    if($child->summary) {
		                  $summary = $sanitizer->text($child->summary);
                    } else {
		                  $summary = $sanitizer->text($child->body); 
                    }
                    if(!$summary) {
                      $summary = "Additional information about ".$child->title." available by clicking the link above.";
                    }
		                $summary = (strlen($summary) > 255) ? substr($summary,0,250).'...' : $summary;
                   echo "<li class=' text-muted'><a class='' href='{$child->url}'>{$child->title}</a><br>{$summary}</li>";
                }			
              echo "</ul></li>";
           }
			?>  
    
    
    
    
    
     <?
  if($page->children("template=working_group")->count()) {
    echo "<ul class='list list-icon icon-chevron-right'>
          <li class='text-bold'>{$page->parent->title} Sub Groups</li>";
      foreach($page->children as $child) {
        echo "<li><a href='{$child->url}'>{$child->title}</a></li>"; 
      }
    echo "</ul>";
  }
  ?>  
      <?
  // The following finds all of the locations  this staff person is tied with, loops through and prints.
  $matches = $pages->find("id=$page->relate_staff_chair, sort=alphabetical");
  if(count($matches)) {
    echo "<h3>Leadership &amp; Members</h3>";
  }
  unset($i);
  foreach($matches as $match) {
    $i++; // Increments the key
    $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
    if ($match->image) {
      $img_sized = $match->image->size(300);
      $tempimg = "<div class='col-sm-4'>
                <a href='{$match->url}' class='text-bold thumbnail' title='{$match->title}'>
                <img src='{$img_sized->url}' class='img-responsive ' alt='{$match->title} {$img_sized->description}'>
                </a>
              </div>";
      $tempcss = "padding-top-sm";  // This helps push the text down to balance out the position of the text next to the image
    } else {
      $tempimg = "<div class='col-sm-4'>
                <a href='{$match->url}' class='text-bold thumbnail' title='{$match->title}'>
                <img src='{$config->urls->templates}assets/brand/icons/user.jpg' class='img img-responsive img-rounded' alt='{$match->title}'>
                </a>
              </div>";
      $tempcss = "padding-top-sm";
    }
    $tempval .= "<div class='col-sm-6 {$temprow}'>
                {$tempimg}
                  <div class='col-sm-8 $tempcss'>
                    <a href='{$match->url}' class='text-bold' title='{$match->title}'>{$match->title}</a>
                    <div class='text-muted text-xs'>{$match->staff_title}</div>
                  </div>
                 </div>
                 ";
  }
   if($tempval) {
    $temptitle = $matches->count() == "1" ? "Chair" : 'Chairs';   // This changes the title to account for more than 1 location
    echo "<h5 class='border-bottom text-muted'>{$temptitle}</h5>"; 
    echo "<div class='row'>{$tempval}</div>";
    
   unset($tempcss);
   unset($temptitle);
   unset($tempval);
   unset($tempimg);
   unset($i);
   }
  ?>  
  
  <?
  // The following finds all of the locations this staff person is tied with, loops through and prints.
  $matches = $pages->find("id=$page->relate_staff_coordinator, sort=alphabetical");
  $i = 0; // sets a key valye
  foreach($matches as $match) {
    $i++; // Increments the key
    $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
    if ($match->image) {
      $img_sized = $match->image->size(300);
      $tempimg = "<div class='col-sm-4'>
                <a href='{$match->url}' class='text-bold thumbnail' title='{$match->title}'>
                <img src='{$img_sized->url}' class='img-responsive ' alt='{$match->title} {$img_sized->description}'>
                </a>
              </div>";
      $tempcss = "padding-top-md";  // This helps push the text down to balance out the position of the text next to the image
    }else {
      $tempimg = "<div class='col-sm-4'>
                <a href='{$match->url}' class='text-bold thumbnail' title='{$match->title}'>
                <img src='{$config->urls->templates}assets/brand/icons/user.jpg' class='img img-responsive img-rounded' alt='{$match->title}'>
                </a>
              </div>";
      $tempcss = "padding-top-sm";
    }
    $tempval .= "<div class='col-sm-6 {$temprow}'>
                {$tempimg}
                  <div class='col-sm-8 $tempcss'>
                    <a href='{$match->url}' class='text-bold' title='{$match->title}'>{$match->title}</a>
                    <div class='text-muted text-sm'>{$match->staff_title}</div>
                  </div>
                 </div>
                 ";
  }
   if($tempval) {
    $temptitle = $matches->count() == "1" ? "Coordinator" : 'Coordinators';   // This changes the title to account for more than 1 location
    echo "<h5 class='border-bottom text-muted'>{$temptitle}</h5>"; 
    echo "<div class='row'>{$tempval}</div>";
    
   unset($tempcss);
   unset($temptitle);
   unset($tempval);
   unset($tempimg);
   unset($i);
   }
  ?>  
   
    <?
  // The following finds all of the locations this staff person is tied with, loops through and prints.
  $matches = $pages->find("id=$page->relate_staff, sort=alphabetical");
  foreach($matches as $match) {
    $i++; // Increments the key
    $temprow = ($i % 2 == 1 ? 'clear-left' : ''); // adds this class to the 3rd
    if ($match->image) {
      $img_sized = $match->image->size(300);
      $tempimg = "<div class='col-sm-4'>
                <a href='{$match->url}' class='text-bold thumbnail' title='{$match->title}'>
                <img src='{$img_sized->url}' class='img-responsive ' alt='{$match->title} {$img_sized->description}'>
                </a>
              </div>";
      $tempcss = "padding-top-md";  // This helps push the text down to balance out the position of the text next to the image
    }else {
      $tempimg = "<div class='col-sm-4'>
                <a href='{$match->url}' class='text-bold thumbnail' title='{$match->title}'>
                <img src='{$config->urls->templates}assets/brand/icons/user.jpg' class='img img-responsive img-rounded' alt='{$match->title}'>
                </a>
              </div>";
      $tempcss = "padding-top-sm";
    }
    $tempval .= "<div class='col-sm-6 {$temprow}'>
                {$tempimg}
                  <div class='col-sm-8 $tempcss'>
                    <a href='{$match->url}' class='text-bold' title='{$match->title}'>{$match->title}</a>
                    <div class='text-muted text-sm'>{$match->staff_title}</div>
                  </div>
                 </div>
                 ";
  }
   if($tempval) {
    $temptitle = $matches->count() == "1" ? "Member" : 'Members';   // This changes the title to account for more than 1 location
    echo "<h5 class='border-bottom text-muted'>{$temptitle}</h5>"; 
    echo "<div class='row'>{$tempval}</div>";
    
   unset($tempcss);
   unset($temptitle);
   unset($tempval);
   unset($tempimg);
   unset($i);
   }
  ?>       

         
		<? include("./inc/inc_files.php"); ?>
	</div>
<? include("./inc/nav_well_workinggroup.php"); ?>
</div>
<? include("./inc/foot.php"); 


