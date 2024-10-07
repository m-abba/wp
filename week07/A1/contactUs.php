<?php
$title = 'Contact Us';
include("includes/header.inc");
include("includes/nav.inc");
?>
<section class="box1">
    <h2>For enquiry please fill in the details below.</h2>
    <form>
        <label for="firstname">First Name: </label>
        <input type="text" id="firstname"><br><br>

        <label for="lastname">Last Name: </label>
        <input type="text" id="lastname"><br><br>

        <label for="email">Email address: </label>
        <input type="text" id="email"><br><br>

        <label for="EnquiryDetails">Enquiry Details: </label>
        <textarea id="EnquiryDetails"></textarea><br><br>

        <button type="submit">Submit</button>
    </form>
</section>
<?php
include("includes/footer.inc")
    ?>