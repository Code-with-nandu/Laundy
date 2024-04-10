<?php date_default_timezone_set('Asia/Kolkata'); // LAUNDRY
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

  <title>Ekam <? echo ucfirst($_SESSION['department']); ?> <?/*=$_SESSION['type']*/ ?> Dashboard for <?= $_SESSION['first_name'] ?> <?= $_SESSION['last_name'] ?></title>

  <!-- Bootstrap core CSS -->
  <link href="<? echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap theme -->
  <link href="<? echo base_url(); ?>css/bootstrap-theme.min.css" rel="stylesheet">


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script src="<? echo base_url(); ?>js/bootstrap.min.js"></script>


  <link rel='stylesheet' href='<?= base_url() ?>/css/jquery-ui.css'>
  <script src='<?= base_url() ?>/js/jquery-ui.js'></script>


  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style>
    body {
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

  <script>
    function arrivedfo(pid, uid) {
      if (typeof(uid) == "undefined")
        var uid = "";
      window.location = "<?= site_url("laundry/user/arrivedfo/") ?>" + pid + "/" + uid;
    }

    function delivered(pid, uid) {
      if (typeof(uid) == "undefined")
        var uid = "";
      window.location = "<?= site_url("laundry/user/delivered/") ?>" + pid + "/" + uid;
    }


    $(function() {


      $('input[type=text]').on('keydown', function(e) {
        if (e.which == 13) {
          e.preventDefault();
          $(this).parent().find(".btn-info").click();
        }
      });




      <?
      if (isset($_GET['arrived']) && intval($_GET['arrived']) > 0) { ?>
        $("#arrivedid").focus();


      <?
        unset($_GET['uid']);
      } ?>


      <?
      if (isset($_GET['uid']) && intval($_GET['uid']) > 0) { ?>
        history(<?= intval($_GET['uid']) ?>);

      <? } ?>

    });
  </script>

</head>


<body role="document">

  <!-- Fixed navbar -->
  <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<? echo site_url(); ?>">Ekam <?/* echo ucfirst($_SESSION['department']); ?> <?=$_SESSION['type'] */ ?>Dashboard for <?= ucfirst($_SESSION['first_name']) ?> <?= ucfirst($_SESSION['last_name']) ?></a>
        <a href="<? echo site_url(); ?>/login/logout"><button class="btn btn-xs btn-danger" type="button">Logout</button></a>
      </div>
    </div>
  </div>
  <br style="clear:both;"> <br>
  <div class="container">
    <div class="list-group">
      <?
      //echo "<pre>"; print_r($_SESSION);
      if (userIsAllowedTo("laundryfrontoffice")) { ?>

        <script type="text/javascript">
          var discountenabled, dmode, damount, discountappliedtoall = "no";

          function discounttoggle() {
            if (discountappliedtoall == "no") {
              $(".cb").prop('checked', true);
              discountappliedtoall = "yes"
            } else {
              $(".cb").prop('checked', false);
              discountappliedtoall = "no"
            }
            calcall();
          }

          function createbill() {

            if (discountenabled == " No Discount ") {
              if (!confirm(" ALERT!!!! \n\n\n NO DISCOUNT! \n\nCONTINUE ??")) {
                return false;
              } else {
                if (!confirm("   NO DISCOUNT! \n Are you really sure ??")) {
                  return false;
                }
              }
            } else // discount applied ...
            {

            }


            var mode = $("input[name='mode']:checked").val();

            if (!confirm("Do you want to create " + dmode + " bill of amount " + damount + " with " + discountenabled))
              return false;

            console.log("create bill");



            $(".totalcontainer,#gtotal,#itemtotal").removeAttr("disabled");
            var f1 = $("#f1").serialize();

            $(".totalcontainer,#gtotal,#itemtotal").attr("disabled", "disabled");

            $.ajax({
              type: 'POST',
              url: '<? echo site_url(); ?>/laundry/user/createbill/',
              data: f1,
              success: function(msg) {
                var r = $.parseJSON(msg);
                console.log(msg)


                if (r.stat == "ok") {
                  $("#f1")[0].reset()
                  //window.location = "<?= site_url("laundry/user/showbill") ?>/"+r.billid;
                  window.open("<?= site_url("laundry/user/showbill") ?>/" + r.billid);

                } else if (r.stat == "error") {
                  //$("#searchresults").html(msg.message);
                  $("#billstatus").html("Error! " + r.msg);
                } else {

                  //$("#searchresults").html('Unknown error occured');
                  $("#billstatus").html("Error! " + r.msg);
                }

              }
            });



          }


          function calcall() {
            var i = Array(<?
                          $ia = array();
                          foreach ($rates as $k => $lr) {
                            $ia[] = "'" . $lr['item_name'] . "'";
                          }
                          echo implode(",", $ia);
                          ?>);
            for (var ii = 0; ii < i.length; ii++) {
              calc(i[ii]);


            }

            var express = 0;
            //var expresstext =  $( "#chk" ).val();

            //var express = document.getElementById("chk");
            var expressrate = 100;
            var expressrateadv = 200;
            var expressratetwo = 300;
            var itemtotaltemp = parseInt($("#itemtotal").val());
            //console.log("itt",itemtotaltemp,$("#itemtotal").val(),$("#expresscheck").prop("checked"));

            if ($("#expresscheck").prop("checked") == true) {
              //console.log("itfvt");


              if (itemtotaltemp <= 0) {
                express = 0;


              } else if (itemtotaltemp <= 10) {
                express = expressrate;


              } else if (itemtotaltemp <= 20) {
                express = expressrateadv;
              } else // if(itemtotaltemp <= 30)
              {
                express = expressratetwo;
              }

              //alert("CheckBox checked.");
              //$("#expresstotal").val(1);
            }

            $("#expresstotal").val(express);

            var totaltemp = parseInt($("#gtotal").val());
            $("#gtotal").val(totaltemp + express);
          }



          function complimentary() {

            if ($("#statusofcom").val() == "1") {
              $("#statusofcom").val(0);
              $("#complimentaryreason").val("");
              $("#complimentaryreasontxt").html("");
              calcall();
              return false;

            }

            var c = prompt("Reason for making this complimentary?");

            if (confirm(c + "\n\n Are you sure you want to save this reason and make this bill complimentary? ")) {
              $("#statusofcom").val(1);
              $("#complimentaryreason").val(c);
            } else {
              $("#statusofcom").val(0);
              c = "";
            }

            calcall();

            if ($.trim(c) != "") c = "Reason for making this bill complimentary : " + c + "<br><small>To remove complimentary status of the bill click on the button again.</small>";

            $("#complimentaryreasontxt").html(c);
          }


          function calc(item) {

            var mode = $("input[name='mode']:checked").val();

            discountenabled = " No Discount ";
            var rate = 9999;
            var ysbill = 0;
            var ysrate = 0;
            var yagnashala = "NO";
            if (mode == "WASH") {
              dmode = " WASH ";
              if ($("#dis" + item).prop("checked") == true) {
                rate = $("#" + item).attr("wash_rate_discounted");
                discountenabled = " Discount APPLIED : YES ! ";
              } else {
                rate = $("#" + item).attr("wash_rate");

              }

            } else if (mode == "PRESS") {
              dmode = " PRESS ";
              if ($("#dis" + item).prop("checked") == true) {
                rate = $("#" + item).attr("press_rate_discounted");
                discountenabled = " Discount APPLIED : YES ! ";
              } else {
                rate = $("#" + item).attr("press_rate");

              }

            } else if (mode == "BOTH") {
              dmode = " WASH + PRESS ";
              if ($("#dis" + item).prop("checked") == true) {
                rate = parseInt($("#" + item).attr("wash_rate_discounted")) + parseInt($("#" + item).attr("press_rate_discounted"));
                discountenabled = " Discount APPLIED : YES ! ";
              } else {
                rate = parseInt($("#" + item).attr("wash_rate")) + parseInt($("#" + item).attr("press_rate"));

              }
            } else if (mode == "YS_WASH" || mode == "YS_BOTH" || mode == "YS_THREE") {

              yagnashala = "YES";
              if (mode == "YS_THREE") {
                ysrate = "200";
                if ($("#dis" + item).prop("checked") == true) {
                  rate = $("#" + item).attr("press_rate_discounted");
                  discountenabled = " Discount APPLIED : YES ! ";
                } else {
                  rate = $("#" + item).attr("press_rate");

                }
                dmode = " YAGNASHALA WASH DRY PRESS ";
                discountenabled = " No Discount for Yagnashala ";
              } // press
              else if (mode == "YS_WASH") {
                rate = 0;

                ysrate = "150";
                dmode = " YAGNASHALA WASH ";
                discountenabled = " No Discount for Yagnashala ";
              } else // YS_BOTH
              {
                rate = 0;

                ysrate = "200";
                dmode = " YAGNASHALA WASH DRY ";
                discountenabled = " No Discount for Yagnashala ";
              }

            } else {
              rate = 9999;
            }

            if ($("#statusofcom").val() == "1")
              rate = 0;

            var t = parseInt(rate) * parseInt($("#" + item).val());

            $("#tot" + item).val(t).effect("highlight", {
              color: "#00fff6"
            }, 3000);




            var it = 0;
            $(".itot").each(function() {
              //console.log("totalcontainer",$(this).val());
              var ntv = parseInt($(this).val());
              if (ntv > 0)
                it = it + ntv;
            });

            $("#itemtotal").val(it);



            var gt = 0;
            $(".totalcontainer").each(function() {
              //console.log("totalcontainer",$(this).val());
              var ntv = parseInt($(this).val());
              if (ntv > 0)
                gt = gt + ntv;

            });

            if (yagnashala == "YES") {
              if (it <= 20) ysbill = ysrate * 1;
              else if (it <= 40) ysbill = ysrate * 2;
              else if (it <= 60) ysbill = ysrate * 3;
              else if (it <= 80) ysbill = ysrate * 4;
              else if (it <= 100) ysbill = ysrate * 5;
              $("#ys").html("Yagnashala Laundrette Bill : " + ysbill + "<input type=hidden name='ysbill' value='" + ysbill + "'>");
            }

            $("#gtotal").val(gt + ysbill);


            //console.log("item",item,"mode",mode,"rate",rate,"#dis"+item,"tot",t,"gt",gt);
            damount = gt + ysbill;


            $("#gtotal,#itemtotal").effect("highlight", {
              color: "#00fff6"
            }, 6000);


            $("#modestatus").html(dmode + " | " + discountenabled);

            //code by sanket



          }

          function increase(item) {
            console.log("increase " + item);
            var nv = parseInt($("#" + item).val()) + 1;
            $("#" + item).val(nv);
            if (nv > 0)
              $("#" + item).css("background-color", "aqua");
            else
              $("#" + item).css("background-color", "white");

            calc(item);
            calcall();

          }

          function decrease(item) {
            console.log("decrease " + item);
            var nv = parseInt($("#" + item).val()) - 1;
            if (nv < 0)
              nv = 0;
            $("#" + item).val(nv);

            if (nv > 0)
              $("#" + item).css("background-color", "aqua");
            else
              $("#" + item).css("background-color", "white");

            calc(item);
            calcall();
          }

          function newbill(uid, nm, isashramite) {
            var isashramitet;
            if (isashramite == "YES") {
              isashramitet = " <i style='color:red;'>Temporary or Permanent ASHRAMITE</i> ";
            } else isashramitet = "";

            var h = "<form id='f1'><div class='col-sm-12'><center><h1>NEW BILL for <a target='_UID" + uid + "' href='<?= site_url("laundry/user") ?>?uid=" + uid + "'>UID " + uid + "</a> " + nm + "  " + isashramitet + "  </h1></center></div><input type=hidden name='uid' value='" + uid + "' />";


            h = h + "<div class='row'  onclick='calcall()'><div class='col-xs-12'>";
            h = h + '<span id="moderow">';
            h = h + '<label><input type="radio" name="mode" value="WASH" checked> Wash</label>';
            h = h + '&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="mode" value="PRESS"> Press </label>';

            h = h + '&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="mode" value="BOTH"> Wash + Press </label>';

            h = h + '&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="mode" value="YS_WASH"> YS Wash </label>';

            h = h + '&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="mode" value="YS_BOTH">YS Wash Dry </label>';

            h = h + '&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="mode" value="YS_THREE">YS Wash Dry Press</label>';


            //code by sanket

            h = h + '&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="checkbox" id="expresscheck" name="check" value="express" onclick="calcall()">ExPress Charges</label>';





            h = h + '<span></div><br></div>';


            h = h + "<div class='row'><div class='col-xs-3'>Decrease Quantity</div>";
            h = h + "<div class='col-xs-4'>Item</div>";
            h = h + "<div class='col-xs-2'>Increase Quantity</div>";
            h = h + "<div class='col-xs-3'><input type=button value='Discount?' onclick='discounttoggle()' /></div></div>";










            <?
            foreach ($rates as $k => $lr) {
              $i = $lr['item_name'];
            ?>
              h = h + "<div class='row'><div class='col-xs-2'><input type=button class='btn btn-warning form-control bb' onclick='decrease(\"<?= $i ?>\")' value='-'></div>";

              h = h + "<div class='col-xs-2'><input type=text value=0 id='<?= $i ?>' name='<?= $i ?>' wash_rate='<?= $lr['wash_rate'] ?>' press_rate='<?= $lr['press_rate'] ?>' wash_rate_discounted='<?= $lr['wash_rate_discounted'] ?>' press_rate_discounted='<?= $lr['press_rate_discounted'] ?>' class='form-control itot' onkeyup='calc(\"<?= $i ?>\")' ></div>";

              h = h + "<div class='col-xs-3'><span class='itn'><?= $i ?>s</span> <small><br> W: <?= $lr['wash_rate'] ?> P: <?= $lr['press_rate'] ?> / DW: <?= $lr['wash_rate_discounted'] ?> DP: <?= $lr['press_rate_discounted'] ?> </small>  </div>";

              h = h + "<div class='col-xs-2'><input type=button class='btn btn-primary form-control bb' onclick='increase(\"<?= $i ?>\")' value='+'></div>";

              h = h + "<div class='col-xs-1'><input type=checkbox class='form-control cb' id='dis<?= $i ?>' onchange='calc(\"<?= $i ?>\")' ></div>";

              h = h + "<div class='col-xs-2'><input type=text disabled class='form-control totalcontainer' id='tot<?= $i ?>' name='<?= $i ?>_total' ></div></div>";
            <?
            }
            ?>




            h = h + "<div class='row'><div class='col-xs-2' id='ys'><input type=hidden name='ysbill' value='0'>- </div>";
            h = h + "<div class='col-xs-2'> <input type=button class='btn-danger' value='complimentary' onclick='complimentary();'> <input type=hidden id='statusofcom' value='0'  name='iscomplimentary'  /><input type=hidden id='complimentaryreason' name='complimentaryreason' value='' /><span id='complimentaryreasontxt'></span> </div>";
            h = h + "<div class='col-xs-2'> Items: <input type=text disabled id='itemtotal' class='form-control' name='itemtotal' /> </div>";
            h = h + "<div class='col-xs-2'> ExPress: <input type=text id='expresstotal' class='form-control' name='expressamount' /> </div>";


            h = h + "<div class='col-xs-3'> BILL INR <input type=text disabled id='gtotal' class='form-control' name='billamount' /> </div>";
            h = h + "<div class='col-xs-3'> PAID INR <input type=text id='paidamount' class='form-control' name='paidamount' value='0' /> </div></div>";



            h = h + "</form>";
            h = h + "<div id='billstatus'></div>";


            h = h + "<div class='row'><div id='modestatus'>Wash | No Discount</div><br><div class='com-sm-12'><br><input type=button class='btn btn-warning form-control' value='Create Bill' onclick='createbill()'></div></div>";

            $("#searchresults").html("<div class='container'>" + h + "</div>");

            if (isashramite == "YES") {
              //$(".cb").click();
            }

            $(".form-control").css("height", "55px");
            $("#searchresults .row div").css("text-align", "center").css("font-size", "1.5em");
            $("#moderow").css("font-size", "4em");
            $("#gtotal,#itemtotal,.totalcontainer,.itot,#paidamount").css("text-align", "center").css("font-size", "2.5em").css("font-weight", "bold");
            $("#searchresults .row:even").css("background-color", "rgb(254, 248, 192)");
            $("#moderow").css("font-size", "2.5e");
            $("#modestatus").css("font-size", "2.7e");
          }






          function history(uid) //,type)
          {
            $("#searchresults").html(" <hr> History for UID " + uid + " ");


            var str = "uid=" + uid;

            //$( "#results" ).text( str );
            //$( "#submitbutton" ).prop("disabled", true);

            $.ajax({
              type: 'POST',
              url: '<? echo site_url(); ?>/laundry/user/history/' + uid, //+'/'+type,
              data: str,
              success: function(msgr) {
                //alert('wow' + msg);

                var msg = $.parseJSON(msgr);
                if (msg.stat == "ok") {
                  var v = "";
                  if (msg.v) {
                    v = " <img src='<?= site_url() ?>/" + msg.v.photo + "' />  <b> " + msg.v.first_name + " " + msg.v.last_name + "</b> *****" + msg.v.mobile + " <span class='mobileok'>" + msg.v.mobileok + "</span><br>";
                  }
                  $("#searchresults").append(" " + v + " Results Found: " + msg.rowsfound + " <br>");
                  var app = "<table border=1><tr><th>Bill Id</th><th>Status</th><th>Mode</th><th>Amount</th><th colspan=1>Functions</th><th>Log</th></tr>"; // " <input type=button value='New' onclick='newbill("+uid+ ")' /> <hr> Bills: <br>";
                  $(msg.history).each(function(k, b) {
                    console.log(k, b);
                    if (b.mode == "BOTH")
                      b.mode = " Wash + Press ";

                    app = app + "<tr><td>" + b.id + "</td><td><b>" + b.status + "</b> </td><td> <u style='font-size:15px;'>" + b.mode + "</u></td><td>  INR: " + b.billamount + "  (" + b.itemtotal + " Items) Pending Amount INR " + (parseInt(b.billamount) - parseInt(b.paidamount)) + " </td>";

                    app = app + "<td><input type=button value='Print' onclick='searchfp2(" + b.id + ")' />"; //" </td><td>";

                    app = app + " <input type=button value='Arrived' onclick='arrivedfo(" + b.id + "," + b.uid + ")' /> "; //"</td><td>";

                    app = app + " <input type=button value='Delivered' onclick='delivered(" + b.id + "," + b.uid + ")' /> "; //"</td><td>";
                    app = app + " <input type=button value='Comment' onclick='comment(" + b.id + ")' /> </td>";
                    if ($.trim(b.log) != "")
                      app = app + " <td>  " + b.log + "</td>";

                    pp = app + "</tr>";
                  });
                  $("#searchresults").append(app);
                } else if (msg.stat == "error") {
                  $("#searchresults").append(msg.message);

                } else {

                  $("#searchresults").append(' Are you still logged in? Is the Internet Connection On? ');
                }
              }
            });


          }





          function search() {
            var uid = $.trim($("#uid").val());
            var fname = $.trim($("#fname").val());
            var lname = $.trim($("#lname").val());
            var phone = $.trim($("#phone").val());

            $("#searchresults").html('Searching ... Please wait ...');


            var str = "uid=" + uid + "&fname=" + fname + "&lname=" + lname + "&phone=" + phone;

            //$( "#results" ).text( str );
            //$( "#submitbutton" ).prop("disabled", true);

            $.ajax({
              type: 'POST',
              url: '<? echo site_url(); ?>/laundry/user/search/',
              data: str,
              success: function(rm) {
                var rmsg = $.parseJSON(rm);
                //console.log("MSGGGG",rmsg.stat)
                //alert('wow' + msg);
                if (rmsg.stat == "ok") {
                  $("#searchresults").html("Accounts Found: " + rmsg.rowsfound);
                  $(rmsg.rows).each(function(k, v) {
                    console.log(k, v);
                    var ia = "";
                    if (v.isashramite == "YES") ia = " <b style='color:red;'>Temp /  Permanent ASHRAMITE</b> ";
                    var app = "<br> UID #" + v.id + " : " + ia + " " + v.first_name + " " + v.last_name + " " + v.mobile;
                    app = app + " <img src='<?= site_url() ?>/" + v.photo + "' />  <span class='mobileok'>" + v.mobileok + "</span>";
                    app = app + " <input type=button value='New' onclick='newbill(" + v.id + " ,\"" + v.first_name + " " + v.last_name + "\" ,\"" + v.isashramite + "\" )' /> ";

                    if (v.unpaid) {
                      app = app + " <div style='background-color:red;color:yellow'  onclick='history(" + v.id + ")' >";
                      $.each(v.unpaid, function(upk, upb) {
                        app = app + " <br>  " + upb['itemtotal'] + " items Pending " + (parseInt(upb['billamount']) - parseInt(upb['paidamount'])) + "/- Bill   " + upb['log'] + "  ";
                      });
                      app = app + " </div>";
                    } else
                      app = app + " <input type=button value='History' onclick='history(" + v.id + ")' /> ";


                    $("#searchresults").append(app);
                  });
                } else if (rmsg.stat == "error") {
                  $("#searchresults").html(rmsg.message);

                } else {

                  $("#searchresults").html('Unknown error occured');
                }
              }
            });



            return false;





          }


          function comment(pid) {
            //$("#searchresults").html(" DELIVERED FROM FRONT office pid " + pid)

            var c = prompt("Add Comment");
            c = c.replace(/[^a-zA-Z0-9-_]/g, '');

            if (c == "Add Comment" || $.trim(c) == "") return false;

            if (confirm(c + "\n\n Are you sure you want to add this comment? ")) {
              window.location = "<?= site_url("laundry/user/addcomment") ?>/" + pid + "/" + encodeURIComponent(c);
            }

          }

          function searchfp(billid) {
            if (billid > 0)
              var pid = billid;
            else
              var pid = $.trim($("#pid").val());
            console.log("pid ", pid);
            //$("#searchresultfp").html("pid " + pid)
            //window.location= "<?= site_url("laundry/user/showbill") ?>/"+pid;
            window.open("<?= site_url("laundry/user/showbill") ?>/" + pid);
          }

          function searchfp2(billid) {
            if (billid > 0)
              var pid = billid;
            else
              var pid = $.trim($("#pid").val());
            console.log("pid ", pid);
            //$("#searchresultfp").html("pid " + pid)
            //window.location= "<?= site_url("laundry/user/showbill2") ?>/"+pid;
            window.open("<?= site_url("laundry/user/showbill2") ?>/" + pid);
          }


          function clr() {
            $("#uid").val("");
            $("#fname").val("");
            $("#lname").val("");
            $("#phone").val("");
            $("#pid").val("");
            $("#bpid").val("");
            $("#searchresultfp").html("");
            $("#searchresults").html("");
            $("#searchresultsp").html("");
          }

          function report() {
            console.log("daily report " + $("#daily").val() + " " + $("#reporttype").val());

            if ($.trim($("#reporttype").val()) == "notdelivered") {
              window.open("<?= site_url("laundry/user/report/notdelivered") ?>");
            } else {
              if ($.trim($("#reporttype").val()) == "" || $.trim($("#daily").val()) == "")
                return false;

              window.open("<?= site_url("laundry/user/report") ?>/" + $("#reporttype").val() + "/" + $("#daily").val());
            }
          }


          function durationreport() {
            console.log("duration report " + $("#fdate").val() + " " + $("#tdate").val());
            window.open("<?= site_url("laundry/welcome/durationreport") ?>/" + $("#fdate").val() + "/" + $("#tdate").val());

          }


          $(function() {
            $("#daily").datepicker({
              dateFormat: 'yymmdd'
            });
            $("#fdate").datepicker({
              dateFormat: 'yymmdd'
            });
            $("#tdate").datepicker({
              dateFormat: 'yymmdd'
            });
          });
        </script>
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

        <div class="row">
          <div class="col-md-12">
            <?
            if (isset($_GET['arrived']) && intval($_GET['arrived']) > 0) {
              echo  "<div class=' btn-warning'><h1> ARRIVED : BILL #" . $_GET['arrived'] . "</h1></div";
            }
            ?>
          </div>
        </div>

      <?  }




      if (userIsAllowedTo("laundrybackoffice")) {
      ?>

        <script type="text/javascript">
          function searchp() {
            var bpid = $.trim($("#bpid").val());
            console.log("bpid ", bpid);
            $("#searchresultsp").html("pid " + bpid)
          }

          function arrived(pid) {
            $("#searchresultsp").html(" ARRIVED at backoffice pid " + pid)
          }

          function sent(pid) {
            $("#searchresultsp").html(" Sent from backoffice pid " + pid)
          }
        </script>

        BACKOFFICE Dashboard:
        <span>
          | <input type=text id='bpid' placeholder="Parcel ID" />
          <input type=button onclick='searchp();' value='Load PID' class='btn-info btn' />
        </span>
        <hr>
        <div id='searchresultsp'></div>
      <?

      }

      echo "</div>";
      ?>


    </div>
  </div>

  </div> <!-- /container -->


  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->

</body>

</html>






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









<script>
  $(function() {

    $("#togmorediv").hide();



  });

  function togmore() {
    $("#togmorediv").toggle("slow");
    //$("#previous_course_details").css("height","75px");

  }

  function save() {


    alert("Yet to implement saving funcitonality! JGD!");
  }


  function allocate() {
    alert("Room Allocation functionality is yet to implemented! JGD!");
  }

  function selallrooms() {
    //selectallrooms bulkspan      $("input:checkbox").attr('checked','checked');

    $("input:checkbox").attr('checked', 'checked');
  }

  function bulkupload() {
    alert("Bulk Upload functionality is yet to implemented! JGD!");
  }

  function bulkprint() {
    alert("Bulk Printing functionality is yet to implemented! JGD!");
  }

  //togmorebutton
</script>
<?
function userIsAllowedTo($doThis)
{ //echo " do this is = ({$doThis}) and rights =({$_SESSION['rights']})";
  if (trim($doThis) == "") return true;

  $found = strpos($_SESSION["rights"], $doThis);
  if ($found === false) { //echo "NOT FOUND";

    return false;
  } // string needle NOT found in haystack
  else {
    return true;
  }   // string needle found in haystack

}
?>