<?php if ($this->session->flashdata('status')) : ?>
  <div class="alert alert-success">
    <?= $this->session->flashdata('status') ?>
  </div>


<?php endif; ?>

<h1>Welcome to Art of living Internanal Center</h1>
This is Art Of living Internamnal center,
<style>
  .asd{
    padding-top: 50px;
    padding-bottom: 40px;
    background-color: #eee;
  }

  .itn {
    font-size: 30px;

  }

  #modestatus {
    font-size: 45px;
    color: #0003ff;
    background-color: #21ffff;
    margin: 30px;
  }
</style>

<style type="text/css">
  td,
  th {
    text-align: center;
    padding: 10px;
  }

  .s {
    border: 1px double black;
    padding: 13px;
    margin: 5px;
    background-color: #efc551;
    min-height: 90px;
  }

  .tb {
    width: 70px;
  }

  .mobileok {
    color: red;
    font-size: 15px;
  }
</style>

<style>
  .datesel {
    float: left;
    text-align: center;
    margin-left: 10px;
  }

  .ui-content {
    background-color: lightcyan;
    font-weight
  }

  .l {
    font-weight: bold;
  }

  .req {
    color: red;
    margin-left: 5px;
  }

  .half {
    width: 50%;
    float: left;
  }

  .half2 {
    text-align: center;
  }

  .cam {
    float: center;
  }

  .namediv,
  .threecols {
    width: 33%;
    float: left;
  }

  .twocols {
    width: 50%;
    float: left;
  }

  .fourcols {
    width: 25%;
    float: left;
  }

  .filldiv {
    font-weight: bold;
    font-size: 32px;
    float: left;
    margin-left: 15px;
  }

  .cen {
    text-align: center;
  }

  .hgender {
    width: 45%;
    margin-left: 5%;
  }

  .ui-btn,
  label.ui-btn {
    height: 15px;
  }

  @media screen and (max-width: 614px) {

    .half,
    .namediv,
    .twocols,
    .fourcols {
      width: 100%;
    }

    .hgender {
      width: 100%;
      margin-left: 0px;
    }

  }
</style>
<style>
  .datesel {
    float: left;
    text-align: center;
    margin-left: 10px;
  }

  .ui-content {
    background-color: lightcyan;
    font-weight
  }

  .l {
    font-weight: bold;
  }

  .req {
    color: red;
    margin-left: 5px;
  }

  .half {
    width: 50%;
    float: left;
  }

  .half2 {
    text-align: center;
  }

  .cam {
    float: center;
  }

  .namediv,
  .threecols {
    width: 33%;
    float: left;
  }

  .twocols {
    width: 50%;
    float: left;
  }

  .fourcols {
    width: 25%;
    float: left;
  }

  .filldiv {
    font-weight: bold;
    font-size: 32px;
    float: left;
    margin-left: 15px;
  }

  .cen {
    text-align: center;
  }

  .hgender {
    width: 45%;
    margin-left: 5%;
  }

  .ui-btn,
  label.ui-btn {
    height: 15px;
  }

  @media screen and (max-width: 614px) {

    .half,
    .namediv,
    .twocols,
    .fourcols {
      width: 100%;
    }

    .hgender {
      width: 100%;
      margin-left: 0px;
    }

  }
</style>
<body>

<div class="asd">
  <div class="row">
    <div class="col-md-7 s">
      FRONT OFFICE Dashboard: <br>
      | <input type=text id='uid' placeholder="UID" class='tb' />
      | <input type=text id='fname' placeholder="First Name" class='tb' />
      | <input type=text id='lname' placeholder="Last Name" class='tb' />
      | <input type=text id='phone' placeholder="Phone" />
      <input type=button onclick='search();' value='Go' class='btn-info btn' />
      <input type=button onclick='clr();' value='Clear' class='btn-danger btn' />
    </div>

    <div class="col-md-2 s ">
      Show Bill :<br> <input type=text id='pid' class='tb' />
      <input type=button onclick='searchfp2(0);' value='Show Bill' class='btn-info btn' />

    </div>
    <hr>
  </div>
  <div class="row">
    <div id='searchresults'></div>
    <br>
    <div id='searchresultfp'></div>
  </div>
  <div class="row">
    <div class="col-md-5 s">
      <SELECT id='reporttype' class='btn-default btn'>
        <option value=''>Report Type</option>
        <option value='washwashpress'>Wash & Wash+Press</option>
        <option value='press'>Press</option>
        <option value='arrived'>Arrived</option>
        <option value='received'>Received</option>
        <option value='delivered'>Delivered</option>
        <option value='ysdelivered'>Yagnashala Delivered</option>

        <option value='notdelivered'>NOT Delivered</option>
        <option value='complimentary'>Complimentary</option>
      </SELECT>
      Date: <input type="text" id="daily" placeholder="Report Date">
      <input type="button" value="Report" onclick='report()' class='btn-info btn'>

    </div>

    <div class="col-md-3 s">
      Delivered from Front Office: <br><input type=text id='deliveredid' class='tb' />
      <input type=button onclick='delivered($("#deliveredid").val());' value='Delivered Bill' class='btn-info btn' />

    </div>
    <div class="col-md-2 s">
      Arrived from Backoffice : <br><input type=text id='arrivedid' class='tb' />
      <input type=button onclick='arrivedfo($("#arrivedid").val());' value='Arrived Bill' class='btn-info btn' />

    </div>


    <div class="col-md-8 s">

      From Date: <input type="text" id="fdate" placeholder="From Date">

      Till Date: <input type="text" id="tdate" placeholder="Till Date">
      <input type="button" value="Duration Report" onclick='durationreport()' class='btn-info btn'>

    </div>
  </div>

  BACKOFFICE Dashboard:
  <span>
    | <input type=text id='bpid' placeholder="Parcel ID" />
    <input type=button onclick='searchp();' value='Load PID' class='btn-info btn' />
  </span>
  <hr>
  <div id='searchresultsp'></div>
  <?


  echo "</div>";
  ?>


  </div>
  </div>

  </div> <!-- /container -->
  </div>

  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->

</body>
