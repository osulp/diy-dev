<div class="profile">
<div class="divider first">
<h2 id="fullname">
<?php print $firstname;
print $lastname;
 ?>
</h2>
<?php
if ($directoryinfo->field_title[0]["value"]) {
print '<h3>' . $directoryinfo->field_title[0]["value"] .'</h3>';
}
?>
</div>
<div class="directoryinfo">

<?php
if ($branchaddress) {
print '<div class="divider pad">';
print $branchaddress->field_address1[0]["value"]."<br />";
if($branchaddress->field_address2[0]["value"]) print $branchaddress->field_address2[0]["value"]."<br />";
print $branchaddress->field_city[0]["value"] . ", ";
print $branchaddress->field_state[0]["value"] . " ";
print $branchaddress->field_zip[0]["value"];
print '</div>';
}
 ?>


<?php
$phone = $directoryinfo->field_phone[0]["value"];
$fax = $directoryinfo->field_fax[0]["value"];
$primary_duties = $directoryinfo->field_primary_duties[0]["value"];
$subjects = $directoryinfo->field_subjects[0]["value"];

if($email || $phone || $fax || $im) {
  print "<div class=\"divider pad\">";
  if($email) {
    print "<div><span class=\"label\">Email: </span> ";
    print $email;
    print "</div>";
  }
  if($phone) {
    print "<div><span class=\"label\">Phone: </span>";
    print $phone;
    print "</div>";
  }
  if($fax) {
    print "<div><span class=\"label\">Fax: </span>";
    print $fax;
    print "</div>";
  }
  if($im) {
    print "<div><span class=\"label\">IM: </span>";
    print $im;
    print "</div>";
  }
  print "</div> <!-- /divider -->";
}
if($blogs || $websites || $primary_duties || $subjects) {
  print "<div class=\"divider pad last\">";
  if($blogs) {
    print "<div><span class=\"label\">Blogs: </span>";
    print $blogs;
    print "</div>";
  }
  if($websites) {
  print "<div><span class=\"label\">Websites: </span>";
  print $websites;
  print "</div>";
  }
  if($primary_duties) {
  print "<div><span class=\"label\">Primary Duties: </span>";
  print $primary_duties;
  print "</div>";
  }
  if($subjects) {
  print "<div><span class=\"label\">Subjects: </span>";
  print $subjects;
  print "</div>";
  }

  print "</div> <!-- /divider -->";
}
?>
</div></div> <!-- /directoryinfo, /profile -->
