<?php if ($this->session->flashdata('status')) : ?>
  <div class="alert alert-success">
    <?= $this->session->flashdata('status') ?>
  </div>


<?php endif; ?>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- //bootstapmin.css add -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">

	 <!-- Bootstrap theme -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js" integrity="sha256-eTyxS0rkjpLEo16uXTS0uVCS4815lc40K2iVpWDvdSY=" crossorigin="anonymous"></script>

<h1>Welcome to Art of living Internanal Center</h1>
This is Art Of living Internamnal center,
<style>
  .asd {
    padding-top: 50px;
    padding-left: 400px;
    padding-right: 400px;
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
  td,
  th {
    text-align: center;
    padding: 10px;
  }

  .l {
    border: 1px double black;
    padding: 13px;
    margin: 5px;
    background-color: #efc551;
    min-height: 90px;
  }

  .tb {
    width: 70px;
  }
  @media (max-width: 768px) {
    /* Adjustments for smaller screens */
    .container {
      width: 100%;
    }
    .asd {
    padding-top: 20px; /* Adjust as needed */
    padding-left: 10px; /* Adjust as needed */
    padding-right: 10px; /* Adjust as needed */
    padding-bottom: 20px; /* Adjust as needed */
    margin-bottom: 50px ;
    background-color: #eee;
}


.itn {
    font-size: 20px; /* Adjust as needed for mobile responsiveness */
}

#modestatus {
    font-size: 30px; /* Adjust as needed for mobile responsiveness */
    margin: 20px 0; /* Adjust as needed for mobile responsiveness */
}

td,
th {
    text-align: center;
    padding: 5px; /* Adjust as needed for mobile responsiveness */
}

.l {
    border: 1px double black;
    padding: 10px; /* Adjust as needed for mobile responsiveness */
    margin: 5px;
    background-color: #efc551;
    min-height: 60px; /* Adjust as needed for mobile responsiveness */
}

.tb {
    width: 100%; /* Adjust as needed for mobile responsiveness */
}
h1{
  margin-top: 50px;
}
  }
</style>




  <div class="asd">


  <div class="row">
    <div class="col-md-7 l">
      FRONT OFFICE Dashboard: <br>
      | <input type=tex id='uid' placeholder="UID" class='tb' />
      | <input type=tex id='fname' placeholder="First Name" class='tb' />
      | <input type=tex id='lname' placeholder="Last Name" class='tb' />
      | <input type=tex id='phone' placeholder="Phone" />
      <input type=button onclick='search();' value='Go' class='btn-info btn' />
      <input type=button onclick='clr();' value='Clear' class='btn-danger btn' />
    </div>

    <div class="col-md-2 l ">
      Show Bill :<br> <input type=tex id='pid' class='tb' />
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
    <div class="col-md-5 l">
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
      Date: <input type="tex" id="daily" placeholder="Report Date">
      <input type="button" value="Report" onclick='report()' class='btn-info btn'>

    </div>

    <div class="col-md-3 l">
      Delivered from Front Office: <br><input type=tex id='deliveredid' class='tb' />
      <input type=button onclick='delivered($("#deliveredid").val());' value='Delivered Bill' class='btn-info btn' />

    </div>
    <div class="col-md-2 l">
      Arrived from Backoffice : <br><input type=tex id='arrivedid' class='tb' />
      <input type=button onclick='arrivedfo($("#arrivedid").val());' value='Arrived Bill' class='btn-info btn' />

    </div>


    <div class="col-md-8 l">

      From Date: <input type="tex" id="fdate" placeholder="From Date">

      Till Date: <input type="tex" id="tdate" placeholder="Till Date">
      <input type="button" value="Duration Report" onclick='durationreport()' class='btn-info btn'>

    </div>
  </div>

  </div>



