<?php 
include './header.php';
include './nav.php';
?>
<div class="container-fluid px-5">
    <br>
    <div class="row">
        <div class="col">
            <h5>CONTACT US</h5>
            <p>This is a portal to file RTI applications/first appeals online along with payment gateway. Payment can be made through internet banking, debit/credit cards of Master/Visa, RuPay cards and UPI. Through this portal, RTI applications/first appeals can be filed by Indian Citizens for all Ministries/Departments and other Public Authorities of Central Government. RTI applications/first appeals should not be filed for other Public authorities under State Govt. through this portal.
            <br><br>
            <b> read instructions carefully while submitting request/appeal. </b></p>
        </div>
    </div>
</div>
<br>
<script>
    document.getElementById("contact-nav").classList.add("active");
    document.getElementById("contact-nav").style.fontWeight = 600;
    document.getElementById("rti-nav").classList.remove("active");
    document.getElementById("apel-nav").classList.remove("active");
    document.getElementById("status-nav").classList.remove("active");
    document.getElementById("history-nav").classList.remove("active");
    document.getElementById("home-nav").classList.remove("active");
</script>
<?php
include './footer.php';
?>
</body>

</html>