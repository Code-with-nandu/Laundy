<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); // LAUNDRY

class User extends CI_Controller {

   function __construct()
   {
      session_start();
      parent::__construct();
      if ( !isset($_SESSION['username']) ) {
         redirect('login');
      }
      if(  $_SESSION["department"] != "laundry" ) {
         redirect('login/logout');



      }
      $this->load->model("error_model","err");
      //die($this->err->getoneimage());

      //echo "<pre>"; print_r($_SESSION); die();
   }



   public function addcomment($billid='',$comment='')
   {
        /*
        if(intval($billid)<=0)
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br>  INVALID Acknowledgement Id #".$billid."<br><br> </h1></center>");
        */

        $this->load->database("default");
        $billa = $this->db->where("id",intval($billid))->get("0101_laundry_bill")->result_array();

        if( empty($billa)  )
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br> Data not found for Acknowledgement Id #".$billid."<br><br> </h1></center>");

        $bill = array_pop($billa);

        $uid = $bill['uid'];


        $this->load->database("default");
        $this->db
            ->where("id",intval($billid))
            ->where("uid",intval($uid))
            ->limit(1)
            ->update("0101_laundry_bill",
            array(
                "log"=>$bill['log']." || COMMENT by {$_SESSION['first_name']} ({$_SESSION['userid']}) at ".date("H:i a d-m-Y")." ".urldecode($comment)
            )
        );
        header("Location: ".site_url("laundry/user")."/?uid=".$bill['uid']);


   }


    public function report($type='',$date='')
    {
        $showbillitems = array("notdelivered","washwashpress","press","arrived","received");

        $this->load->database("default");


        $timestamp = strtotime($date);

        $datef = date("d M Y",$timestamp);
        $datefy = date("d M Y", strtotime("yesterday", $timestamp)  );
        $range = "";


        $si = "STATUS";
        $specialreport = "NO";
        if($type == "notdelivered")
        {
            $this->db->where("status","ARRIVED");
            $this->db->where("`delivered` = ''");
            $this->db->order_by("date_created","desc");
            $label = "NOT-DELIVERED ";
        }
        else if(intval($date)<=0 || intval($date)<= 20180101 || intval($date) >= 20800101   )
        {

            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br>  Invalid Date <br><br></h1></center>");
        }
        else if($type == "washwashpress")
        {

            //$beginOfDay = strtotime("midnight", $timestamp);
            //$endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
            $beginOfDay = strtotime($date. ' -1 day 10:30:00');
            $endOfDay   = strtotime($date. ' 10:29:59');

            $this->db->where("status","RECEIVED");
            $this->db->where("(`mode` ='BOTH' or `mode` = 'WASH' )");
            $this->db->where("`date_created` >=  '{$beginOfDay}' AND `date_created` <=  '{$endOfDay}' AND `date_created` !=  ''  ");

            $label = "WASH & WASH PRESS";
            $range = "  {$datefy} 10:30 AM <br>to {$datef} 10:29 AM ";
            $si = "ITEMS";
        }
        else if($type == "press")
        {

            //$beginOfDay = strtotime("midnight", $timestamp);
            //$endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
            $beginOfDay = strtotime($date. ' -1 day 10:30:00');
            $endOfDay   = strtotime($date. ' 10:29:59');
            $this->db->where("status","RECEIVED");
            $this->db->where("mode","PRESS");
            $this->db->where("`date_created` >=  '{$beginOfDay}' AND `date_created` <=  '{$endOfDay}' AND `date_created` !=  ''  ");

            $label = "PRESS";
            $range = "  {$datefy} 10:30 AM <br>to {$datef} 10:29 AM ";
            $si = "ITEMS";
        }
        else if($type == "received")
        {
            $this->db->where("status","RECEIVED");
            //$beginOfDay = strtotime("midnight", $timestamp);
            //$endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;

            //$this->db->where("`arrived` >=  '{$beginOfDay}' AND `arrived` <=  '{$endOfDay}' AND `arrived` !=  ''  ");

            $label = "RECEIVED";
            $range = "   {$datef}  "; //$range = "  {$datefy} Midnight <br>to {$datef} Midnight ";
        }
        else if($type == "arrived")
        {

            $beginOfDay = strtotime("midnight", $timestamp);
            $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
            $this->db->where("status","ARRIVED");
            $this->db->where("`arrived` >=  '{$beginOfDay}' AND `arrived` <=  '{$endOfDay}' AND `arrived` !=  ''  ");

            $label = "ARRIVED";
            $range = "   {$datef}  "; //$range = "  {$datefy} Midnight <br>to {$datef} Midnight ";
        }
        else if($type == "delivered")
        {

            $beginOfDay = strtotime("midnight", $timestamp);
            $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
            $this->db->where("status","DELIVERED");
            $this->db->where("`delivered` >=  '{$beginOfDay}' AND `delivered` <=  '{$endOfDay}' AND `delivered` !=  ''  ");

            $label = "DELIVERED";
            $range = "   {$datef}  ";
        }
        else if($type == "ysdelivered")
        {

            $beginOfDay = strtotime("midnight", $timestamp);
            $endOfDay   = strtotime("tomorrow", $beginOfDay) - 1;
            $this->db->where("status","DELIVERED");
            $this->db->where("(`mode` = 'YS_BOTH' || `mode` = 'YS_WASH' || `mode` = 'YS_THREE' )  ");
            $this->db->where("`delivered` >=  '{$beginOfDay}' AND `delivered` <=  '{$endOfDay}' AND `delivered` !=  ''  ");

            $label = "YAGNASHALA DELIVERED";
            $range = "   {$datef}  ";
        }
        else if($type == "complimentary")
        {

             /*
            $beginOfDay = date("01-m-Y",$timestamp);
            $endOfDay   = date("t-m-Y", $timestamp);

            $beginOfDayts = strtotime("midnight", $beginOfDay);
            $endOfDayts   = strtotime("tomorrow", $endOfDay) - 1;
            */

            $specialreport = "complimentary";


            $label = "COMPLIMENTARY";
            $range = "";// "   {$beginOfDay} - {$endOfDay}  ";

            $this->db->order_by("date_created","desc")->where("billamount","0")->where("`id` > '0' ");
            //$this->db->where("`date_created` >=  '{$beginOfDayts}' AND `date_created` <=  '{$endOfDayts}' AND `delivered` !=  ''  ");

            //die("-----");

        }
        else if($type == "kfdsl")
        {

            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br> Unrecognized Reportt Type<br><br> </h1></center>");
        }
        else
        {


            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br>  Unrecognized Report Type<br><br> </h1></center>");
        }



        //echo " Date ".$date. " ts ".$timestamp." beginOfDay : ".$beginOfDay. " endOfDay ".$endOfDay;

        //echo " start ".date("d-m-Y",$beginOfDay);
        //echo " end ".date("d-m-Y",$endOfDay);





        $billa = $this->db->get("0101_laundry_bill")->result_array();

        //echo $this->db->last_query();
        //echo "<hr><pre> "; print_r($billa);
        if(empty($billa) && $specialreport=="NO") echo "<center><h1>No Matching Acknowledgement found in {$label} <br>REPORT FOR <br>{$range}  </h1></center>";
        else
        {
            /*
            id] => 110
            [uid] => 22202
            [mode] => PRESS
            [status] => RECEIVED
            [date_created] => 1532758548
            [iscomplimentary] => 0
            [itemtotal] => 7
            [billamount] => 35
            */

            $imar = $this->db->get("0101_laundry_rates")->result_array();
            $ima = array();
            $imarate = array();

            if(!empty($imar))
            {
                foreach ($imar as $imakey => $im)
                {
                    $ima[$im['id']]= $im['item_name'];
                    $imarate[$im['id']]= $im;
                }
            }?>
            <!DOCTYPE html>
                <html lang="en">
                  <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <meta name="description" content="">
                    <meta name="author" content="">
                    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

                    <title>Ekam Laundry Report</title>

                    <!-- Bootstrap core CSS -->
                    <link href="<? echo base_url();?>/css/bootstrap.min.css" rel="stylesheet">
                    <!-- Bootstrap theme -->
                    <link href="<? echo base_url();?>/css/bootstrap-theme.min.css" rel="stylesheet">


                     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
                    <script src="<? echo base_url();?>/js/bootstrap.min.js"></script>


                    <link rel='stylesheet' href='<? echo base_url();?>//css/jquery-ui.css'>
                    <script src='<? echo base_url();?>//js/jquery-ui.js'></script>
            <?

            echo "<table border=1 class='tbl'><tr><td colspan='16'><h1>{$label}<br> REPORT <br>{$range} </h1> Generated : ".date("H:i A d-m-Y")."</td></tr>";


            if($specialreport=="complimentary")
            {
 //               echo "<pre>";  print_r($billa);

                if(!empty($billa))
                {

                    echo "<tr><th>#</th><th>Date</th><th>Acknowledgement Id</th><th>UID</th><th>MODE</th><th>{$si}</th><th>Items</th><th>WORTH INR</th> </tr>";
                    $i = 0 ;

                    foreach ($billa as $key => $b)
                    {
                        $i++;
                        $biaa = $this->db->where("bill_id",$b['id'])->get("0101_laundry_billitems")->result_array();
                        $bia = array();

                        $totalamt = 0;


                        if(!empty($biaa))
                        {
                            foreach ($biaa as $bik => $bi)
                            {
                                $itemid = $bi['item_id'];
                                $biq = $bi['quantity'];

                                $irate = 9999;
                                if($b['mode']=="WASH")
                                {
                                    $irate = $imarate[$itemid]["wash_rate"];
                                }
                                else if($b['mode']=="PRESS")
                                {
                                    $irate = $imarate[$itemid]["press_rate"];
                                }
                                else
                                {
                                    $irate = $imarate[$itemid]["press_rate"] + $imarate[$itemid]["wash_rate"];
                                }

                                $totalamt = $totalamt + ( $biq *  $irate  );
                            }
                        }


                        echo "<tr><td>{$i}</td><td>".date("d/m/Y",$b['date_created'])."</td><td><a target='_t{$b['id']}' href='".site_url("laundry/user/showbill/".$b['id'])."'>{$b['id']}</a> ";
                         echo "</td><td><a target='_u{$b['uid']}' href='".site_url("laundry/user/?uid=".$b['uid'])."'>{$b['uid']}</a></td><td>{$b['mode']}</td><td>{$b['status']}</td><td>{$b['itemtotal']}</td><td>{$totalamt}</td> </tr>";
                    }
                }


            }
            else
            {

                echo "<tr><th>#</th><th>Acknowledgement Id</th><th>UID</th><th>MODE</th><th>{$si}</th><th>Items</th><th>BILLED INR</th><th>PAID INR</th></tr>";

                $count = 0 ; $INR = 0; $pINR = 0;

                $i = 0 ;
                foreach ($billa as $k => $b)
                {
                    $i++;

                    if($b['mode']=="BOTH")
                        $b['mode'] = "WASH PRESS";
                    else if($b['mode']=="YS_BOTH")
                        $b['mode'] = "YAGNASHALA WASH DRY";
                    else if($b['mode']=="YS_WASH")
                        $b['mode'] = "YAGNASHALA WASH";
                    else if($b['mode']=="YS_THREE")
                        $b['mode'] = "YAGNASHALA WASH DRY PRESS";

                    if(in_array($type, $showbillitems))
                    if($b['mode'] == "WASH PRESS" || $b['mode'] == "WASH" || $b['mode'] == "PRESS")
                    {
                        $items = "";
                        $ia = $this->db->where("bill_id",$b['id'])->get("0101_laundry_billitems")->result_array();
                       
                        if(!empty($ia))
                        {
                            foreach ($ia as $ik => $it)
                            {
                                $itn = " UNKNOWN ";
                                if(isset($ima[$it['item_id']]))
                                    $itn = $ima[$it['item_id']];
                                if(intval($it['amount'])<10) $it['amount'] .="&nbsp;&nbsp;";
                                else if(intval(trim($it['amount']))<100) $it['amount'] .="&nbsp;";


                                if(intval($it['quantity'])<10) $it['quantity'] .="&nbsp;&nbsp;";

                                $items .= "<tr class='fltr'><td> INR {$it['amount']}/- </td><td>  &nbsp;  &nbsp;<b> {$it['quantity']}</b></td><td>  &nbsp; {$itn}</td>   </tr>";
                            }
                        //echo "<tr><td colspan='8'> {$items} </td></tr>";
                        $b['status'] = "<table class='lf'>".$items."</table>";
                        }
                    }

                    echo "<tr><td>{$i}</td><td><a target='_t{$b['id']}' href='".site_url("laundry/user/showbill/".$b['id'])."'>{$b['id']}</a> ";
                    echo "<br> R ".date("d M y",$b['date_created']);
                    if(trim($b['arrived'])>0)
                        echo "<br> A ".date("d M y",$b['arrived']);
                    if(trim($b['delivered'])>0)
                        echo "<br> D ".date("d M y",$b['delivered']);


                    $arr = "";
                    if($type == "arrived")
                    {
                        $LRS = "No Reminders Sent<br>";
                        if(intval($b['lastremindersent'])>0)
                            $LRS = "Last Reminder Sent: ".date("d/m/Y H:i:s A",$b['lastremindersent'])." <br>";

                        $arr = " <br>  ".$LRS." <button id='remindbtn{$b['id']}' onclick='remind({$b['id']});' >Send Reminder</button> ";
                    }


                    echo "</td><td><a target='_u{$b['uid']}' href='".site_url("laundry/user/?uid=".$b['uid'])."'>{$b['uid']}</a></td><td>{$b['mode']}</td><td>{$b['status']}</td><td>{$b['itemtotal']}</td><td>{$b['billamount']}</td><td>{$b['paidamount']} {$arr}</td></tr>";



                    $count = $count + $b['itemtotal'];
                    $INR = $INR + $b['billamount'];
                    $pINR = $pINR  + $b['paidamount'];
                }

                echo "<tr><td colspan='4'><h2> {$count} Items </h2></td><td colspan='4'><h2>BILLED INR {$INR} /- <br>PAID INR {$pINR} /- </h2></td></tr>
                </table>";
            }

            ?>
            <style type="text/css">
                .tbl {
                    margin:0px auto;

                }
                .fltr td{
                        padding: 1px;
                        text-align: left;
                }
                td,th,h1
                        {
                        text-align: center;
                        padding: 5px;
                        }
                h2 {
                        text-align: center;
                        padding-top: 8px;

                }
                .lf {
                    text-align: left;
                }
            </style>
            <script type="text/javascript">
                function remind(billid)
                {
                    $("#remindbtn"+billid).html("Sending ...");

                    $.get("<?=site_url("laundry/sms/remind")?>/"+billid, function(data, status){
                        console.log("Data: " + data + "\nStatus: " + status);
                        $("#remindbtn"+billid).parent().html(data);
                    });



                }
            </script>
            <?
        }



    }

    public function arrivedfo($billid='',$uid='')
    {
        if(intval($billid)<=0)
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br>  INVALID Acknowledgement Id #".$billid."<br><br> </h1></center>");


        $this->load->database("default");
        $billa = $this->db->where("id",intval($billid))->get("0101_laundry_bill")->result_array();

        if( empty($billa)  )
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br>  Data not found for Acknowledgement Id #".$billid."<br><br> </h1></center>");

        $bill = array_pop($billa);
        if($bill['mode']=="BOTH")
            $bill['mode'] = "Wash + Press";
        else if($bill['mode']=="YS_WASH")
            $bill['mode'] = "Yagnashala<br>Wash";
        else if($bill['mode']=="YS_BOTH")
            $bill['mode'] = "Yagnashala<br>Wash + Dry";
        else if($bill['mode']=="YS_THREE")
            $bill['mode'] = "Yagnashala<br>Wash + Dry + Press";

        $uid = $bill['uid'];

        if(trim($bill['arrived'])!="")
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br>  Acknowledgement Id #".$billid." is already marked as ARRIVED <br><br> </h1></center>");
        if(trim($bill['delivered'])!="")
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br>  Acknowledgement Id #".$billid." is already marked as DELIVERED <br><br> </h1></center>");

        $this->load->database("default");
        $this->db
            ->where("id",intval($billid))
            ->where("uid",intval($uid))
            ->limit(1)
            ->update("0101_laundry_bill",
            array(
                "status"=>"ARRIVED",
                "arrived"=>time() ,
                "log"=>$bill['log']." || FRONTOFFICE ARRIVED by {$_SESSION['first_name']} ({$_SESSION['userid']}) at ".date("H:i a d-m-Y")
            )
        );


        /*---------------------------sms--------------------*/

        $va = $this->db
            ->limit(10)
            ->where("id",$uid)
            ->select(array("id","first_name","photo","last_name","mobile")) //
            ->get("m_visitor")
            ->result_array();

        $v = array();

        if (!empty($va)) // Result NOT Empty
        {
            $v= array_pop($va);
            $phonenumber=$v['mobile'];
            $v['mobile'] = substr($v['mobile'], -5);
        }

        if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $phonenumber,  $phonenumber_matches ) )
        {
            $phonenumber=$phonenumber_matches[1].$phonenumber_matches[2].$phonenumber_matches[3];
        }
        $phonenumber='+91'.$phonenumber;

//echo $phonenumber;
//        $phonenumber='+919497319299';
//        $phonenumber='+917356523019';


        $first_name=$v['first_name'];
        $last_name=$v['last_name'];
        $billamount=$bill['billamount'];
        $product_count='';
        $product_name='';

        $billitema = $this->db->where("bill_id",intval($billid))->get("0101_laundry_billitems")->result_array();
        $itema =   $this->db->get("0101_laundry_rates")->result_array();

        $items = array();
        foreach ($itema as $key => $item)
        {
            $items[$item["id"]] = $item;
        }

        $t_name=array();
        foreach ($billitema as $key => $i)
        {
            $product_count=$i['quantity'];
            $product_name=$items[$i['item_id']]['item_name'];
            $product_name_count=$product_name.'-'.$product_count;
            array_push($t_name, $product_name_count);
        }
        $product_name=implode(",", $t_name);
        $product_mode= $bill['mode'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
          //  CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
            CURLOPT_URL => "http://api.msg91.com/api/v5/flow/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"616d0272898e2e517228e986\",\n  \"sender\": \"ASHLRY\",\n  \"mobiles\": \"$phonenumber\"
            ,\n  \"var1\": \"$uid\"\n
            ,\n  \"var2\": \"$first_name\"\n
            ,\n  \"var3\": \"$billid\"\n
            ,\n  \"var4\": \"$product_name\"\n
            }",
            CURLOPT_HTTPHEADER => array(
                "authkey: 195358ArYJS6WU60f036e3P1",
                "content-type: application/JSON",
                'Cookie: PHPSESSID=l1q2efp61ab769s31gkqshojs7'
            ),
        ));
        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

////////////////////////////////////////////////



///////////////////////////////
        

//        if ($err) {
//            echo "cURL Error #:" . $err;
//        } else {
//            echo $response;
//        }
        /*---------------------------sms--------------------*/

        header("Location: ".site_url("laundry/user")."/?uid=".$bill['uid']."&arrived=".$bill['id']);
    }

    public function arrivedbo($billid='',$uid='')
    {
        die("not yet started");
        if(intval($billid)<=0)
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br>  INVALID Acknowledgement Id #".$billid."<br><br> </h1></center>");

        $this->load->database("default");
        $billa = $this->db->where("id",intval($billid))->get("0101_laundry_bill")->result_array();

        if( empty($billa)  )
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br> Data not found for Acknowledgement Id #".$billid."<br><br> </h1></center>");

        $bill = array_pop($billa);

        $uid = $bill['uid'];



        if(trim($bill['arrived'])!="")
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br>  Acknowledgement Id #".$billid." is already marked as ARRIVED <br><br> </h1></center>");
        if(trim($bill['delivered'])!="")
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br>  Acknowledgement Id #".$billid." is already marked as DELIVERED <br><br> </h1></center>");


        $this->load->database("default");
        $this->db
            ->where("id",intval($billid))
            ->where("uid",intval($uid))
            ->limit(1)
            ->update("0101_laundry_bill",
            array(
                "status"=>"BOARRIVED",
                "arrived"=>time(),
                "log"=>$bill['log']." || BACKOFFICE ARRIVED by {$_SESSION['first_name']} ({$_SESSION['userid']}) at ".date("H:i a d-m-Y")
            )
        );
        header("Location: ".site_url("laundry/user")."/?uid=".$bill['uid']."&arrived=".$bill['id']);
    }


    public function delivered($billid='',$uid='')
    {
        if(intval($billid)<=0)
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br>  INVALID Acknowledgement Id #".$billid."<br><br> </h1></center>");


        $this->load->database("default");
        $billa = $this->db->where("id",intval($billid))->get("0101_laundry_bill")->result_array();



        if( empty($billa)  )
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br> Data not found for Acknowledgement Id #".$billid."<br><br></h1></center>");

        $bill = array_pop($billa);

        $uid = $bill['uid'];


        if(trim($bill['delivered'])!=""  ) //&& !isset($_GET['override']))
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br>  Acknowledgement Id #".$billid." is already marked as DELIVERED <br><br> </h1></center>");

        $this->load->database("default");
        $this->db
            ->where("id",intval($billid))
            ->where("uid",intval($uid))
            ->limit(1)
            ->update("0101_laundry_bill",
            array(
                "status"=>"DELIVERED",
                "paidamount"=>($bill['billamount']+$bill['ysbill']),
                "delivered"=>time(),
                "log"=>$bill['log']." || DELIVERED by {$_SESSION['first_name']} ({$_SESSION['userid']}) at ".date("H:i a d-m-Y")
            )
        );

        $bia = $this->db
            ->where("bill_id",intval($billid))
            ->get("0101_laundry_billitems")
            ->result_array();
        if(!empty($bia))
        {
            foreach ($bia as $bik => $bi)
            {
                $this->db
                ->where("id", $bi['id'])
                ->limit(1)
                ->update("0101_laundry_billitems",
                            array(
                                "quantity_returned"=>$bi['quantity']
                            )
                        );

            }
        }
        if(isset($_GET['override'])) die("DONE");

        header("Location: ".site_url("laundry/user")."/?uid=".$bill['uid']);
    }


    public function index()
    {
            $this->load->database("default");
            $data['page'] = "index";
            $data['query'] = "";
            $data['rates'] =   $this->db->get("0101_laundry_rates")->result_array();
            //echo "<pre>"; print_r($data); die();
        $this->load->view('laundry/user_dashboard', $data);
    }

    public function changepaidamount($billid=0,$newpaidamount=0)
    {

        if(intval($billid)<=0)
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br>  INVALID Acknowledgement Id #".$billid."<br><br> </h1></center>");

        $this->load->database("default");
        $billa = $this->db->where("id",intval($billid))->get("0101_laundry_bill")->result_array();

        if( empty($billa)  )
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><br><br><br> Data not found for Acknowledgement Id #".$billid."<br><br><br><br></h1></center>");


        $bill = array_pop($billa);

        if($newpaidamount > $bill['paidamount'] && $newpaidamount > 0  )
        {
             $this->db
                    ->limit(1)
                    ->where("id",$billid)
                    ->update("0101_laundry_bill",
                            array(
                                "paidamount"=>$newpaidamount,
                                "log"=>$bill['log']." || Updated by {$_SESSION['first_name']} ({$_SESSION['userid']}) at ".date("H:i a d-m-Y"),
                                )
                            );
             if($this->db->affected_rows()==1)
                echo "ok";
             else
                echo "Could not update the information.";
        }
        else
        {
            echo " Invalid amount. ";
        }
    }

    public function showbill($billid)
    {

        $this->load->database("default");
        $billa = $this->db->where("id",intval($billid))->get("0101_laundry_bill")->result_array();
        $billitema = $this->db->where("bill_id",intval($billid))->get("0101_laundry_billitems")->result_array();
        $itema =   $this->db->get("0101_laundry_rates")->result_array();

        $items = array();
        foreach ($itema as $key => $item)
            {
                $items[$item["id"]] = $item;
            }

        //echo "<pre>" ; print_r($billa); print_r($billitema);

        if( empty($billa) || empty($billitema) )
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br> Data not found for Acknowledgement Id #".$billid."<br><br></h1></center>");

        $bill = array_pop($billa);

        if($bill['mode']=="BOTH")
            $bill['mode'] = "Wash + Press";
        else if($bill['mode']=="YS_WASH")
            $bill['mode'] = "Yagnashala<br>Wash";
        else if($bill['mode']=="YS_BOTH")
            $bill['mode'] = "Yagnashala<br>Wash + Dry";
        else if($bill['mode']=="YS_THREE")
            $bill['mode'] = "Yagnashala<br>Wash + Dry + Press";


        $va = $this->db
                        ->limit(10)
                        ->where("id",$bill['uid'])
                        ->select(array("id","first_name","photo","last_name","mobile")) //
                        ->get("m_visitor")
                        ->result_array();

        $v = array();

        if (!empty($va)) // Result NOT Empty
        {
            $v= array_pop($va);
            $phonenumber=$v['mobile'];
            $v['mobile'] = substr($v['mobile'], -5);
        }

        if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $phonenumber,  $phonenumber_matches ) )
        {
            $phonenumber=$phonenumber_matches[1].$phonenumber_matches[2].$phonenumber_matches[3];
        }
        $phonenumber='+91'.$phonenumber;
//       $phonenumber='+91'.$v['mobile'];
        /*---------------------------sms--------------------*/
//echo $phonenumber;
//        $phonenumber='+919497319299';
//        $phonenumber='+917356523019';
        $uid=$bill['uid'];
        $first_name=$v['first_name'];
        $last_name=$v['last_name'];
        $billamount=$bill['billamount'];
        $product_count='';
        $product_name='';

        $t_name=array();
        foreach ($billitema as $key => $i)
        {
            $product_count=$i['quantity'];
            $product_name=$items[$i['item_id']]['item_name'];
            $product_name_count=$product_name.'-'.$product_count;
            array_push($t_name, $product_name_count);
        }
        $product_name=implode(",", $t_name);
        $product_mode= $bill['mode'];
        $curl = curl_init();

//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"615145cd85ba0746993103ca\",\n  \"sender\": \"ASHLRY\",\n  \"mobiles\": \"$phonenumber\"
//            ,\n  \"var1\": \"$uid\"\n
//            ,\n  \"var2\": \"$first_name\"\n
//            ,\n  \"var3\": \"$billamount\"\n
//            ,\n  \"var4\": \"$billid\"\n
//            ,\n  \"var5\": \"$product_name\"\n
//            ,\n  \"var6\": \"$product_mode\"\n
//            }",
//            CURLOPT_HTTPHEADER => array(
//                "authkey: 195358ArYJS6WU60f036e3P1",
//                "content-type: application/JSON"
//            ),
//        ));

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://api.msg91.com/api/v5/flow/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',

        //     CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"616d05af0c22321e0d6f1d62\",\n  \"sender\": \"ASHLRY\",\n  \"mobiles\": \"$phonenumber\"
            ,\n  \"var1\": \"$uid\"\n
            ,\n  \"var2\": \"$first_name\"\n
            ,\n  \"var3\": \"$billid\"\n
            ,\n  \"var4\": \"$product_name\"\n
            ,\n  \"var5\": \"$product_mode\"\n

            }",
            CURLOPT_HTTPHEADER => array(
                "authkey: 195358ArYJS6WU60f036e3P1",
                "content-type: application/JSON",
                'Cookie: PHPSESSID=l1q2efp61ab769s31gkqshojs7'
            ),
        ));

        //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);



        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        // print_r($response);

    //    if ($err) {
    //        echo "cURL Error #:" . $err;
        
    //    } else {
    //        echo $response;
    //    }
        /*---------------------------sms--------------------*/

        ?>
        <!DOCTYPE html>
        <html>
        <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>


        <script src="<? echo base_url();?>/js/JsBarcode.all.min.js"></script>

        <title>Acknowledgement #<?=$billid?></title>
        <style type="text/css">
            .billitem{
                margin-top: 5px;
                padding:5px;

            }
            td,th {
                text-align: center;
                border: 1px solid grey;
                padding: 7px;
            }

        </style>
        <script type="text/javascript">

            function changepaidamount(paidamount,billamount,pendingamount)
            {
                //alert("pendingamount : "+pendingamount);
                if(parseInt(pendingamount)==0)
                {
                    return false;
                }
                //newpaidamount = prompt("Pending amount is: "+pendingamount+" \n Change the Paid Amount from "+paidamount+" to "+newpaidamount+"? ",newpaidamount);

                pendingamount = prompt("Pending amount is: "+pendingamount+" \n How much money is being paid right now? ",pendingamount);

                newpaidamount = parseInt(pendingamount)+ parseInt(paidamount);

                if(newpaidamount<paidamount || newpaidamount > billamount)
                {
                    alert("Invalid Amount entered");
                    return false;
                }

                $.ajax({
                    type: 'GET',
                    url: '<? echo site_url("laundry/user/changepaidamount/{$billid}");?>/'+newpaidamount,
                    success: function(msg)
                    {
                        if (msg!="ok")
                            alert(msg);

                        window.location = "<?=site_url("laundry/user/showbill/{$billid}")?>";

                    }
                });
            }
            $(function(){
                $.get("<?=site_url("laundry/sms/received")?>", function(data, status){
                    console.log("Data: " + data + "\nStatus: " + status);
                });
                window.print();
            });
        </script>
        </head>

        <body>
         <CENTER>
            <img id="barcode" style="width:200px; height:15px;" />
            <a href='<?=site_url("laundry/user")?>' style='text-decoration: none;'>
            <h1><?=strtoupper($bill['mode'])?></h1> <h2>Acknowledgement #<?=$bill['id']?> </h2></a>

            <h3>STATUS : <?=strtoupper($bill['status'])?></h3>
            <p><?
            if(!empty($v))
            {
                echo "<a  href='".site_url("laundry/user")."?uid={$v['id']}' style='text-decoration: none;'>UID {$v['id']}</A> ". $v['first_name']." ".$v["last_name"]." *****".$v['mobile'];
            }
            ?></p>
            <?
            $count=0;
            echo "<table >";
            echo "<tr class='billitem'><th>#</th><th>Item</th><th>Qty</th><th>Amount</th><th>Qty Returned</th></tr>";
            foreach ($billitema as $key => $i)
            {
                $count++;

                    //echo "<span>{$count} </span>";
                    //echo "<span>  id:{$i['id']}/UID:{$i['uid']} </span>";

                    echo "<tr class='billitem'>";

                    echo " <td>{$count} </td>";
                    echo "<td> {$items[$i['item_id']]['item_name']}(s) </td>";

                    echo " <td>{$i['quantity']} </td>";
                    echo "<td>  {$i['amount']} </td>";
                    echo "<td>  {$i['quantity_returned']}</td> </tr>";

            }

            if($bill['ysbill']>0)
            {
                    $count++;
                    echo "<tr class='billitem'>";

                    echo " <td>{$count} </td>";
                    echo "<td> Yagnashala Laundrette Charges </td>";

                    echo " <td> - </td>";
                    echo "<td>  {$bill['ysbill']}/- </td>";
                    echo "<td>  - </td> </tr>";
            }
                if($bill['expressamount'] > 0){
                    echo "<tr><th>&nbsp;</th><th>Express Charges: </th><th>-</th><th>INR {$bill['expressamount']}/-</th><th>&nbsp;</th></tr>";

                }
            echo "<tr><th>&nbsp;</th><th>Total</th><th>{$bill['itemtotal']}</th><th>INR {$bill['billamount']}/-</th><th>&nbsp;</th></tr></table>";

            //<h2>INR <?=$bill['billamount']? >/-  for <?=$bill['itemtotal']? > Items </h2>

            if( ($bill['billamount']-$bill['paidamount']) <=0 )
                {
                    echo "<h2>PAID</h2>";
                }
            else
                {
                ?>
                <h2 onclick='changepaidamount(<?=$bill['paidamount']?>,<?=($bill['billamount'])?>,<?=($bill['billamount']-$bill['paidamount']) ?>)'>INR <?=($bill['billamount']-$bill['paidamount']) ?>/-  Pending </h2>
                <?
                }
            ?>

            <h4><?=str_replace("||", "<br>",  $bill['log'])?></h4>
            <p>We are not responsible for any loss or damage of any garments.</p>
            <p>8:30 AM to 12:30 PM  &  2:00 PM to 6:30 PM (Sunday till 5:00 PM) </p>
         </CENTER>
        </body>

        <script type="text/javascript">
         JsBarcode("#barcode", "<?=$billid?>", {
          format: "code128",
          width:12,
          height:50,
          displayValue: false
    });
    </script>
        </html>
        <?
    }


    public function showbill2($billid)
    {

        $this->load->database("default");
        $billa = $this->db->where("id",intval($billid))->get("0101_laundry_bill")->result_array();
        $billitema = $this->db->where("bill_id",intval($billid))->get("0101_laundry_billitems")->result_array();
        $itema =   $this->db->get("0101_laundry_rates")->result_array();

        $items = array();
        foreach ($itema as $key => $item)
            {
                $items[$item["id"]] = $item;
            }

        //echo "<pre>" ; print_r($billa); print_r($billitema);

        if( empty($billa) || empty($billitema) )
            die("<center><h1 style='font-size:60px; color:red; border:10px double red; background-color:lightyellow; '> <br><img style='width:50%;' src='".$this->err->getoneimage()."'><br><br> Data not found for Acknowledgement Id #".$billid."<br><br></h1></center>");

        $bill = array_pop($billa);

        if($bill['mode']=="BOTH")
            $bill['mode'] = "Wash + Press";
        else if($bill['mode']=="YS_WASH")
            $bill['mode'] = "Yagnashala<br>Wash";
        else if($bill['mode']=="YS_BOTH")
            $bill['mode'] = "Yagnashala<br>Wash + Dry";
        else if($bill['mode']=="YS_THREE")
            $bill['mode'] = "Yagnashala<br>Wash + Dry + Press";


        $va = $this->db
                        ->limit(10)
                        ->where("id",$bill['uid'])
                        ->select(array("id","first_name","photo","last_name","mobile")) //
                        ->get("m_visitor")
                        ->result_array();

        $v = array();

        if (!empty($va)) // Result NOT Empty
        {
            $v= array_pop($va);
            $phonenumber=$v['mobile'];
            $v['mobile'] = substr($v['mobile'], -5);
        }

        if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $phonenumber,  $phonenumber_matches ) )
        {
            $phonenumber=$phonenumber_matches[1].$phonenumber_matches[2].$phonenumber_matches[3];
        }
        $phonenumber='+91'.$phonenumber;
//       $phonenumber='+91'.$v['mobile'];
        /*---------------------------sms--------------------*/
//echo $phonenumber;
//        $phonenumber='+919497319299';
//        $phonenumber='+917356523019';
        $uid=$bill['uid'];
        $first_name=$v['first_name'];
        $last_name=$v['last_name'];
        $billamount=$bill['billamount'];
        $product_count='';
        $product_name='';

        $t_name=array();
        foreach ($billitema as $key => $i)
        {
            $product_count=$i['quantity'];
            $product_name=$items[$i['item_id']]['item_name'];
            $product_name_count=$product_name.'-'.$product_count;
            array_push($t_name, $product_name_count);
        }
        $product_name=implode(",", $t_name);
        $product_mode= $bill['mode'];
        $curl = curl_init();

//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"615145cd85ba0746993103ca\",\n  \"sender\": \"ASHLRY\",\n  \"mobiles\": \"$phonenumber\"
//            ,\n  \"var1\": \"$uid\"\n
//            ,\n  \"var2\": \"$first_name\"\n
//            ,\n  \"var3\": \"$billamount\"\n
//            ,\n  \"var4\": \"$billid\"\n
//            ,\n  \"var5\": \"$product_name\"\n
//            ,\n  \"var6\": \"$product_mode\"\n
//            }",
//            CURLOPT_HTTPHEADER => array(
//                "authkey: 195358ArYJS6WU60f036e3P1",
//                "content-type: application/JSON"
//            ),
//        ));

//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "POST",
//            CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"616d0272898e2e517228e986\",\n  \"sender\": \"ASHLRY\",\n  \"mobiles\": \"$phonenumber\"
//            ,\n  \"universalid\": \"$uid\"\n
//            ,\n  \"name\": \"$first_name\"\n
//            ,\n  \"pacelid\": \"$billid\"\n
//            ,\n  \"items\": \"$product_name\"\n
//            ,\n  \"jobs\": \"$product_mode\"\n

//            }",
//            CURLOPT_HTTPHEADER => array(
//                "authkey: 195358ArYJS6WU60f036e3P1",
//                "content-type: application/JSON"
//            ),
//        ));



        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

//        if ($err) {
//            echo "cURL Error #:" . $err;
//        } else {
//            echo $response;
//        }
        /*---------------------------sms--------------------*/

        ?>
        <!DOCTYPE html>
        <html>
        <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>


        <script src="<? echo base_url();?>/js/JsBarcode.all.min.js"></script>

        <title>Acknowledgement #<?=$billid?></title>
        <style type="text/css">
            .billitem{
                margin-top: 5px;
                padding:5px;

            }
            td,th {
                text-align: center;
                border: 1px solid grey;
                padding: 7px;
            }

        </style>

        </head>

        <body>
         <CENTER>
            <img id="barcode" style="width:200px; height:15px;" />
            <a href='<?=site_url("laundry/user")?>' style='text-decoration: none;'>
            <h1><?=strtoupper($bill['mode'])?></h1> <h2>Acknowledgement #<?=$bill['id']?> </h2></a>

            <h3>STATUS : <?=strtoupper($bill['status'])?></h3>
            <p><?
            if(!empty($v))
            {
                echo "<a  href='".site_url("laundry/user")."?uid={$v['id']}' style='text-decoration: none;'>UID {$v['id']}</A> ". $v['first_name']." ".$v["last_name"]." *****".$v['mobile'];
            }
            ?></p>
            <?
            $count=0;
            echo "<table >";
            echo "<tr class='billitem'><th>#</th><th>Item</th><th>Qty</th><th>Amount</th><th>Qty Returned</th></tr>";
            foreach ($billitema as $key => $i)
            {
                $count++;

                    //echo "<span>{$count} </span>";
                    //echo "<span>  id:{$i['id']}/UID:{$i['uid']} </span>";

                    echo "<tr class='billitem'>";

                    echo " <td>{$count} </td>";
                    echo "<td> {$items[$i['item_id']]['item_name']}(s) </td>";

                    echo " <td>{$i['quantity']} </td>";
                    echo "<td>  {$i['amount']} </td>";
                    echo "<td>  {$i['quantity_returned']}</td> </tr>";

            }

            if($bill['ysbill']>0)
            {
                    $count++;
                    echo "<tr class='billitem'>";

                    echo " <td>{$count} </td>";
                    echo "<td> Yagnashala Laundrette Charges </td>";

                    echo " <td> - </td>";
                    echo "<td>  {$bill['ysbill']}/- </td>";
                    echo "<td>  - </td> </tr>";
            }
                if($bill['expressamount'] > 0){
                    echo "<tr><th>&nbsp;</th><th>Express Charges: </th><th>-</th><th>INR {$bill['expressamount']}/-</th><th>&nbsp;</th></tr>";

                }
            echo "<tr><th>&nbsp;</th><th>Total</th><th>{$bill['itemtotal']}</th><th>INR {$bill['billamount']}/-</th><th>&nbsp;</th></tr></table>";

            //<h2>INR <?=$bill['billamount']? >/-  for <?=$bill['itemtotal']? > Items </h2>

            if( ($bill['billamount']-$bill['paidamount']) <=0 )
                {
                    echo "<h2>PAID</h2>";
                }
            else
                {
                ?>
                <h2 onclick='changepaidamount(<?=$bill['paidamount']?>,<?=($bill['billamount'])?>,<?=($bill['billamount']-$bill['paidamount']) ?>)'>INR <?=($bill['billamount']-$bill['paidamount']) ?>/-  Pending </h2>
                <?
                }
            ?>

            <h4><?=str_replace("||", "<br>",  $bill['log'])?></h4>
            <p>We are not responsible for any loss or damage of any garments.</p>
            <p>8:30 AM to 12:30 PM  &  2:00 PM to 6:30 PM (Sunday till 5:00 PM) </p>
         </CENTER>
        </body>

        <script type="text/javascript">
         JsBarcode("#barcode", "<?=$billid?>", {
          format: "code128",
          width:12,
          height:50,
          displayValue: false
    });
    </script>
        </html>
        <?
    }


    public function createbill($query="none")
    {
        $r = array("stat"=>"error","msg"=>"Invalid Data");
        $this->load->database("default");

        $items =   $this->db->get("0101_laundry_rates")->result_array();



        if(intval($_POST['itemtotal'])>0 && intval($_POST['uid'])>0 )
         {

            $this->db->trans_begin();



              $billdata = array(
                            "uid"=>intval($_POST['uid']),
                            "mode"=>trim($_POST['mode']),
                            "status"=>"RECEIVED",
                            "log"=>"RECEIVED by {$_SESSION['first_name']} ({$_SESSION['userid']}) at ".date("H:i a d-m-Y"),
                            "date_created"=>time(),
                            "iscomplimentary"=>trim($_POST['iscomplimentary']),
                            "complimentaryreason"=>trim($_POST['complimentaryreason']),
                            "itemtotal"=>intval($_POST['itemtotal']),
                            "billamount"=>intval($_POST['billamount']),
                            "ysbill"=>intval($_POST['ysbill']),
                            "paidamount"=>intval($_POST['paidamount']),
                            "expressamount"=>intval($_POST['expressamount'])
                            );

              $rst1=  $this->db->insert("0101_laundry_bill",$billdata);



              $billid = $this->db->insert_id();
              $itemcount =0;
              $billitems = 0;
              if(intval($billid)>0)
              {
                foreach ($items as $key => $item)
                {
                    $i = $item['item_name'];
                    if(
                        isset($_POST[$i])
                        &&
                        intval($_POST[$i])>0
                        &&
                        isset($_POST[$i."_total"])
                        &&
                        (   (
                                intval($_POST[$i."_total"])>0
                            )
                            ||
                            (
                                intval($_POST['iscomplimentary'])=="1"
                                &&
                                trim($_POST['complimentaryreason'])!=""
                            )
                            ||
                            (
                                intval($_POST["ysbill"])>0
                            )
                        )
                      ) //if
                    {
                        $itemcount ++;

                        $billitemdata = array(
                                        "uid"=>intval($_POST['uid']),
                                        "bill_id"=>$billid,
                                        "item_id"=>$item['id'],
                                        "quantity"=>intval($_POST[$i]),
                                        "amount"=>intval($_POST[$i."_total"])
                                        );

                        $this->db->insert("0101_laundry_billitems",$billitemdata);



                        if($this->db->insert_id()>0)
                            $billitems ++;

                    }
                }
            }
            else
                $r['msg']= " Could not create the Acknowledgement id ";

            if($this->db->trans_status() === FALSE || intval($billid)==0 || $itemcount==0 || $itemcount != $billitems )
                {
                   $this->db->trans_rollback();
                   $r['msg']=  "failed  -- item count: ($itemcount)  billitems:($billitems) billid:($billid) ";
                }
            else{
                   $this->db->trans_commit();
                   $r['stat']= "ok";
                   $r['billid']= $billid;
                   $r['msg']= "Successfully Saved";


                }



         }


        //echo "<pre>";     print_r($_POST);
        echo json_encode($r);
    }


    public function history($uid=0)
    {
        $r = array("stat"=>"ok");
        $this->load->database("default");
        $r['history'] =  $this->db->where("uid",intval($uid))->order_by("date_created","desc")->get("0101_laundry_bill")->result_array();
        $r['rowsfound'] = count($r['history']);
        if($r['rowsfound']>0)
        {
            foreach ($r['history'] as $hk => $h)
            {
               $r['history'][$hk]['log'] = str_replace("||", "<br>",  $h['log']);
            }
        }

        $this->db->where("id",$uid);
        $results = $this->db
                        ->limit(1)
                        ->select(array("id","first_name","photo","last_name","mobile")) //
                        ->get("m_visitor")
                        ->result_array();

        if (!empty($results)) // Result NOT Empty
                {
                    $row = array_pop($results);
                    //$row['mobile'] = substr($row['mobile'], -5);
                    $row['mobileok'] = " ";
                    $row['mobile'] =  substr(trim($row['mobile']), -10);
                    if(intval($row['mobile'])>999999999)
                    {
                        ///$row['mobile'] = intval(substr($row['mobile'], -10));

                        if(strlen($row['mobile'])!=10  )
                        {
                            $row['mobileok'] = "INVALID MOBILE! SMS will NOT be sent!";
                        }
                        $row['mobile'] = substr($row['mobile'], -5);
                    }
                    else
                        {
                            $row['mobile']= 99999;
                            $row['mobileok'] = "INVALID MOBILE! SMS will NOT be sent!";
                        }


                    $r['v'] = $row;
                }

        echo json_encode($r);
    }



    public function vsearch($query="none")
    {
            $data['page'] = "search";
            $data['query'] = $query;
                $this->load->view('laundry/search', $data);
    }

    public function re($query="none")
    {
            $data['page'] = "search";
            $data['query'] = $query;
                $this->load->view('laundry/newentry', $data);
    }


    public function search()
    {       $r['rowsfound'] =0;
            $r['stat'] = "error";
            $data['page'] = "dosearch";
            $uid = intval($_POST['uid']);
            $phone = intval($_POST['phone']);
            $fname = trim($_POST['fname']);
            $lname = trim($_POST['lname']);

          //    $this->load->view('housing_front_search', $data);

            $r['msg'] = " Please fill more information" ;

            if($uid==0 && $phone ==0  && strlen($fname)<2 && strlen($lname)<2)
            {

            }
            else
            {


                $this->load->database('default');

                if($uid>0)
                    $this->db->where("id",$uid);

                if($phone>0)
                    $this->db->where("mobile",$phone);

                if(strlen($fname)>=2)
                {
                    $this->db->like("first_name",$fname,'both');
                }

                if(strlen($lname)>=2)
                {
                    $this->db->like("last_name",$lname,'both');
                }



                $results = $this->db
                                ->limit(10)
                                ->order_by("id","desc")
                                ->select(array("id","first_name","photo","last_name","mobile")) //
                                ->get("m_visitor");


                if (!empty($results)) // Result NOT Empty
                {
                    $r['stat'] = "ok";
                    $r['msg'] = " -- " ;
                    $r['rowsfound'] = $results->num_rows();
                    foreach ($results->result_array() as $row)
                        {
                            //die($row['mobile']);
                            $row['mobileok'] = "";
                            $row['mobile'] =  substr(trim($row['mobile']), -10);
                            if(intval($row['mobile'])>999999999)
                            {
                                $row['mobile'] = intval(substr($row['mobile'], -10));

                                if(strlen($row['mobile'])!=10  )
                                {
                                    $row['mobileok'] = "INVALID MOBILE! SMS will NOT be sent!";
                                }
                                $row['mobile'] = substr($row['mobile'], -5);
                            }
                            else
                                {
                                    $row['mobile']= 99999;
                                    $row['mobileok'] = "INVALID MOBILE! SMS will NOT be sent!";
                                }


                            $row['unpaid'] = $this->db
                                        ->where("uid",intval($row['id']))
                                        ->where("`paidamount` < `billamount`")
                                        ->get("0101_laundry_bill")
                                        ->result_array();


                             $ra1 = $this->db
                                        ->where("visitor_id",intval($row['id']))
                                        ->where("`arrival` <= '".date("Ymd")."' ")
                                        ->where("`departure` >= '".date("Ymd")."' ")
                                        ->where("`checked_in` > '1000' ")
                                        ->where("`checked_out` = '0' ")
                                        ->where("stay_type","Ashramite")
                                        ->limit(1)
                                        ->get("0101_released_bed")
                                        ->result_array();



                             $ra2 = $this->db
                                        ->where("visitor_id",intval($row['id']))
                                        ->where("`arrival` <= '".date("Ymd")."' ")
                                        ->where("`departure` >= '".date("Ymd")."' ")
                                        ->where("`checked_in` > '1000' ")
                                        ->where("`checked_out` = '0' ")
                                        ->where("stay_type","Ashramite")
                                        ->limit(1)
                                        ->get("0101_released_bed_2018e")
                                        ->result_array();


                            $ra = array_merge($ra1,$ra2);

                           //echo "<pre>"; print_r($ra); die($this->db->last_query());
                            if(!empty($ra))
                            {
                              $row['isashramite'] = "YES";
                            }
                            else
                            {
                                $row['isashramite'] = "NO";
                            }

                           // echo json_encode($row)."<hr>";
                           $r['rows'][] = $row;
                        }
                }

             } //else

        echo json_encode($r);
    }


}
