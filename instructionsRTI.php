<?php
include './header.php';
include './nav.php';
?>
<div class="container-fluid px-5">
    <br>
    <div class="row">
        <div class="col">
            <h5>Instructions to file a RTI</h5>
            <p>
                <b>1)</b>&nbsp;&nbsp; This Web Portal can be used by Indian citizens to file RTI application online and also to make payment for RTI application online. First appeal can also be filed online. <br>
                <b>2)</b>&nbsp;&nbsp; An applicant who desires to obtain any information under the RTI Act can make a request through this Web Portal to the Ministries/Departments of Government of India. <br>
                <b>3)</b>&nbsp;&nbsp; On clicking at "Submit Request", the applicant has to fill the required details on the page that will appear. <br>
                <b>4)</b>&nbsp;&nbsp; The fields marked * are mandatory while the others are optional. <br>
                <b>5)</b>&nbsp;&nbsp; The text of the application may be written at the prescribed column. <br>
                <b>6)</b>&nbsp;&nbsp; At present, the text of an application that can be uploaded at the prescribed column is confined to 3000 characters only. <br>
                <b>7)</b>&nbsp;&nbsp; Only alphabets A-Z a-z number 0-9 and special characters , . - _ ( ) / @ : & ? \ % are allowed in Text for RTI Request application. <br>
                <b>8)</b>&nbsp;&nbsp; In case an application contains more than 3000 characters, it can be uploaded as an attachment, by using column "Supporting document". <br>
                <b>9)</b>&nbsp;&nbsp; Do not upload Aadhar Card or PAN Card or any other personal Identification (Except BPL Card). <br>
                <b>10)</b>&nbsp;&nbsp; PDF file name should not have any blank spaces. <br>
                <b>11)</b>&nbsp;&nbsp; After filling the first page, the applicant has to click on "Make Payment" to make payment of the prescribed fee. <br>
                <b>12)</b>&nbsp;&nbsp; The applicant can pay the prescribed fee through the following modes:
                (a) Internet banking;
                (b) Using credit/debit card of Master/Visa;
                (c) Using RuPay Card. <br>
                <b>13)</b>&nbsp;&nbsp; Fee for making an application is as prescribed in the RTI Rules, 2012. <br>
                <b>14)</b>&nbsp;&nbsp; After making payment, an application can be submitted. <br>
                <b>15)</b>&nbsp;&nbsp; After making payment, if applicant didn’t receive the registration number then applicant is advised to wait for the 24-48 working hours as registration number will be generated after reconciliation. <br>
                <b>16)</b>&nbsp;&nbsp; do not make additional attempt to make payment again. <br>
                <b>17)</b>&nbsp;&nbsp; it is not generated within 24-48 hours kindly send an e-mail at helprtionline-dopt[at]nic[dot]in with transaction details. <br>
                <b>18)</b>&nbsp;&nbsp; No RTI fee is required to be paid by any citizen who is below poverty line as per RTI Rules, 2012. <br>
                <b>19)</b>&nbsp;&nbsp; , the applicant must attach a copy of the certificate issued by the appropriate government in this regard, alongwith the application. <br>
                <b>20)</b>&nbsp;&nbsp; On submission of an application, a unique registration number would be issued, which may be referred by the applicant for any references in future. <br>
                <b>21)</b>&nbsp;&nbsp; The application filed through this Web Portal would reach electronically to the "Nodal Officer" of concerned Ministry/Department, who would transmit the RTI application electronically to the concerned CPIO. <br>
                <b>22)</b>&nbsp;&nbsp; In case additional fee is required representing the cost for providing information, the CPIO would intimate the applicant through this portal. <br>
                <b>23)</b>&nbsp;&nbsp; intimation can be seen by the applicant through Status Report or through his/her e-mail alert. <br>
                <b>24)</b>&nbsp;&nbsp; For making an appeal to the first Appellate Authority, the applicant has to click at "Submit First Appeal" and fill up the page that will appear. <br>
                <b>25)</b>&nbsp;&nbsp; The registration number of original application has to be used for reference. <br>
                <b>26)</b>&nbsp;&nbsp; As per RTI Act, no fee has to be paid for first appeal. <br>
                <b>27)</b>&nbsp;&nbsp; The applicant/the appellant should submit his/her mobile number to receive SMS alert. <br>
                <b>28)</b>&nbsp;&nbsp; Status of the RTI application/first appeal filed online can be seen by the applicant/appellant by clicking at "View Status". <br>
                <b>29)</b>&nbsp;&nbsp; All the requirements for filing an RTI application and first appeal as well as other provisions regarding time limit, exemptions etc., as provided in the RTI Act, 2005 will continue to apply. <br>
            </p>
            </p>
        </div>
    </div>
    <form action="./Backend/existingUser.php" method="POST">
        <div class="row">
            <div class="col-6">
                <div class="mb-3">
                    <div class="radio d-md-flex">
                        <label for="file" class="col-form-label"><span class="text-danger">*</span> Have you file a RTI before?</label>
                        <div class="form-check mx-md-5 my-2">
                            <input type="radio" name="existing" id="yesRadio" value="yes" onclick="showEmail()">&nbsp;&nbsp;Yes
                        </div>
                        <div class="form-check mx-mf-5 my-2">
                            <input type="radio" name="existing" checked id="noRadio" onclick="hideEmail()" value="no">&nbsp;&nbsp;No
                        </div>
                    </div>
                </div>
                <div class="mb-3" id="emailDiv" style="display: none;">
                    <label for="reqEmail" class="form-label"><span class="text-danger">*</span> Email ID</label>
                    <input type="email" class="form-control" id="reqEmail" name="reqEmail">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <div class="form-group">
                        <button class="btn btn-dark text-light" type="submit" name="personalRTI">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<br>
<script>
    document.getElementById("rti-nav").classList.add("active");
    document.getElementById("rti-nav").style.fontWeight = 600;
    document.getElementById("home-nav").classList.remove("active");
    document.getElementById("apel-nav").classList.remove("active");
    document.getElementById("status-nav").classList.remove("active");
    document.getElementById("history-nav").classList.remove("active");
    document.getElementById("contact-nav").classList.remove("active");

    const showEmail = function (){
        document.getElementById("emailDiv").style.display = 'block';
        document.getElementById("reqEmail").setAttribute("required", '')
    }
    const hideEmail = function (){
        document.getElementById("emailDiv").style.display = 'none';
        document.getElementById("reqEmail").removeAttribute("required")
    }
</script>
<?php
include './footer.php';
?>
</body>

</html>