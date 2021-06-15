<?php
set_time_limit(0);
include "config.php";
include "func.php";
include "coinpayments.inc.php";
	$cps = new CoinPaymentsAPI();
	$cps->Setup($private_key, $public_key);

$rscron=mysqli_query($dbconnect,"select * from cronjobs where active=0");
if(mysqli_num_rows($rscron)>0) {
mysqli_query($dbconnect,"update cronjobs set active=1");
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));

$rsmain=mysqli_query($dbconnect,"select * from verifier order by ID limit 0,4");
while($arrmain=mysqli_fetch_array($rsmain)) {
mysqli_query($dbconnect,"update cronjobs set lastid=$arrmain[0]");
$user=$arrmain[1];
$mid=$arrmain[2];
$arr1[1]=$user;

$rs=mysqli_query($dbconnect,"select Username,ref_by from users where Username='$arr1[1]'");
$arr=mysqli_fetch_array($rs);
$user=$arr[0];
$ref_by=$arr[1];

$tablee="matrix$mid";
$rsm=mysqli_query($dbconnect,"select * from membershiplevels where ID=$mid");
$arrm=mysqli_fetch_array($rsm);
$mname=$arrm[1];
$fee=$arrm[2];
$amount=round($amount,5);
$fee=round($fee,5);
$matrixtype=$arrm[3];
$levels=$arrm[4];
$forcedmatrix=$arrm[5];
$refbonus=$arrm[84];
$refbonuspaid=$arrm[83];
$payouttype=$arrm[6];
$matrixbonus=$arrm[7];
$matchingbonus=$arrm[8];
$level1=$arrm[9];
$level2=$arrm[10];
$level3=$arrm[11];
$level4=$arrm[12];
$level5=$arrm[13];
$level6=$arrm[14];
$level7=$arrm[15];
$level8=$arrm[16];
$level9=$arrm[17];
$level10=$arrm[18];
$level1m=$arrm[19];
$level2m=$arrm[20];
$level3m=$arrm[21];
$level4m=$arrm[22];
$level5m=$arrm[23];
$level6m=$arrm[24];
$level7m=$arrm[25];
$level8m=$arrm[26];
$level9m=$arrm[27];
$level10m=$arrm[28];
$level1c=$arrm[29];
$level2c=$arrm[30];
$level3c=$arrm[31];
$level4c=$arrm[32];
$level5c=$arrm[33];
$level6c=$arrm[34];
$level7c=$arrm[35];
$level8c=$arrm[36];
$level9c=$arrm[37];
$level10c=$arrm[38];
$level1cm=$arrm[39];
$level2cm=$arrm[40];
$level3cm=$arrm[41];
$level4cm=$arrm[42];
$level5cm=$arrm[43];
$level6cm=$arrm[44];
$level7cm=$arrm[45];
$level8cm=$arrm[46];
$level9cm=$arrm[47];
$level10cm=$arrm[48];

$textcreditsentry=$arrm[49];
$bannercreditsentry=$arrm[50];
$textcreditscycle=$arrm[51];
$bannercreditscycle=$arrm[52];

$reentry=$arrm[53];
$reentrynum=$arrm[54];
$entry1=$arrm[55];
$entry1num=$arrm[56];
$matrixid1=$arrm[57];
$entry2=$arrm[58];
$entry2num=$arrm[59];
$matrixid2=$arrm[60];
$entry3=$arrm[61];
$entry3num=$arrm[62];
$matrixid3=$arrm[63];
$entry4=$arrm[64];
$entry4num=$arrm[65];
$matrixid4=$arrm[66];
$entry5=$arrm[67];
$entry5num=$arrm[68];
$matrixid5=$arrm[69];
$welcomemail=$arrm[70];
$subject1=stripslashes($arrm[71]);
$message1=stripslashes($arrm[72]);
$eformat1=$arrm[73];
$cyclemail=$arrm[74];
$subject2=stripslashes($arrm[75]);
$message2=stripslashes($arrm[76]);
$eformat2=$arrm[77];
$cyclemailsponsor=$arrm[78];
$subject3=stripslashes($arrm[79]);
$message3=stripslashes($arrm[80]);
$eformat3=$arrm[81];

$f1=$forcedmatrix;
$f2=$forcedmatrix*$forcedmatrix;
$f3=$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f4=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f5=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f6=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f7=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f8=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f9=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f10=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;

if($levels==1) $fquery="Level1<$forcedmatrix"; 
elseif($levels==2) $fquery="Level2<$f2";
elseif($levels==3) $fquery="Level3<$f3";
elseif($levels==4) $fquery="Level4<$f4";
elseif($levels==5) $fquery="Level5<$f5";
elseif($levels==6) $fquery="Level6<$f6";
elseif($levels==7) $fquery="Level7<$f7";
elseif($levels==8) $fquery="Level8<$f8";
elseif($levels==9) $fquery="Level9<$f9";
elseif($levels==10) $fquery="Level10<$f10";

$upline=0;
if($allowlookupforsponsor==1) {
$rsp=mysqli_query($dbconnect,"select ID from $tablee where Username='$ref_by' order by ID limit 0,1");
if(mysqli_num_rows($rsp)>0) {
$arrp=mysqli_fetch_array($rsp);
$upline=$arrp[0];
} else {
$rssp1=mysqli_query($dbconnect,"select Username,ref_by,status from users where Username='$ref_by'");
if(mysqli_num_rows($rssp1)>0) {
$arrsp1=mysqli_fetch_array($rssp1);
$rsp=mysqli_query($dbconnect,"select ID from $tablee where Username='$arrsp1[0]' order by ID limit 0,1");
if(($arrsp1[2]==2)&&(mysqli_num_rows($rsp)>0)) {
$arrp=mysqli_fetch_array($rsp);
$upline=$arrp[0];
} else {
$rssp1=mysqli_query($dbconnect,"select Username,ref_by,status from users where Username='$arrsp1[1]'");
if(mysqli_num_rows($rssp1)>0) {
$arrsp1=mysqli_fetch_array($rssp1);
$rsp=mysqli_query($dbconnect,"select ID from $tablee where Username='$arrsp1[0]' order by ID limit 0,1");
if(($arrsp1[2]==2)&&(mysqli_num_rows($rsp)>0)) {
$arrp=mysqli_fetch_array($rsp);
$upline=$arrp[0];
} else {
$rssp1=mysqli_query($dbconnect,"select Username,ref_by,status from users where Username='$arrsp1[1]'");
if(mysqli_num_rows($rssp1)>0) {
$arrsp1=mysqli_fetch_array($rssp1);
$rsp=mysqli_query($dbconnect,"select ID from $tablee where Username='$arrsp1[0]' order by ID limit 0,1");
if(($arrsp1[2]==2)&&(mysqli_num_rows($rsp)>0)) {
$arrp=mysqli_fetch_array($rsp);
$upline=$arrp[0];
} else {
$rssp1=mysqli_query($dbconnect,"select Username,ref_by,status from users where Username='$arrsp1[1]'");
if(mysqli_num_rows($rssp1)>0) {
$arrsp1=mysqli_fetch_array($rssp1);
$rsp=mysqli_query($dbconnect,"select ID from $tablee where Username='$arrsp1[0]' order by ID limit 0,1");
if(($arrsp1[2]==2)&&(mysqli_num_rows($rsp)>0)) {
$arrp=mysqli_fetch_array($rsp);
$upline=$arrp[0];
} else {
}
}
}
}
}
}

}
}
}
} else {
$rsp=mysqli_query($dbconnect,"select ID from $tablee where Username='$ref_by' order by ID limit 0,1");
if(mysqli_num_rows($rsp)>0) {
$arrp=mysqli_fetch_array($rsp);
$upline=$arrp[0];
}
}

$urid=0;
$rsm=mysqli_query($dbconnect,"select ID from membershiplevels order by ID desc");
while($arrm=mysqli_fetch_array($rsm)) {
$rsp=mysqli_query($dbconnect,"select MainID from matrix$arrm[0] where Username='$user'");
if(mysqli_num_rows($rsp)>0) {
$arrp=mysqli_fetch_array($rsp);
$urid=$arrp[0];
}
}

mysqli_query($dbconnect,"insert into $tablee(Username,Sponsor,ref_by,Level1,Level2,Level3,Level4,Level5,Level6,Level7,Level8,Level9,Level10,Leader,Total,Date,MainID,CDate) values('$user','$ref_by',$upline,0,0,0,0,0,0,0,0,0,0,$upline,0,now(),$urid,now())");
$b=mysqli_insert_id($dbconnect);
if($b>0) {
if($urid==0) mysqli_query($dbconnect,"update $tablee set MainID=$b where ID=$b");
$acountid=$b;
$a[11]=$upline;

mysqli_query($dbconnect,"update users set banners=banners+$bannercreditsentry,textads=textads+$textcreditsentry,status=2 where Username='$user'");

if($refbonuspaid>0&&$refbonus>0) {
$rsb=mysqli_query($dbconnect,"select * from users where Username='$ref_by'");
if(mysqli_num_rows($rsb)>0) {
$arrb=mysqli_fetch_array($rsb);
if(($arrb[14]==2)||($arrb[14]==1&&$freerefbonus==1)) {
mysqli_query($dbconnect,"update users set Total=Total+$refbonus,Unpaid=Unpaid+$refbonus where Username='$ref_by'");
mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$ref_by',$upline,$mid,'$refbonus','Referral Bonus',now())");
	if($refbonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$ref_by'"));
	$result = $cps->CreateWithdrawal($refbonus, 'BTC', $bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$refbonus,Paid=Paid+$refbonus where Username='$ref_by'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$ref_by','Bitcoin: $tid','$refbonus',1,now())");
	}
	}
}
}
}

if($welcomemail==1) {
matrixmail($b,$user,$mid,1);
}

if($matrixtype==1) {

    if ($upline==0)
    {
$rs=mysqli_query($dbconnect,"select ID from $tablee where Level1<$forcedmatrix and ID <>'$acountid' order by ID limit 0,1");
 if (mysqli_num_rows($rs)>0)
 {
 $arr=mysqli_fetch_array($rs);
 assignreferrals($acountid,$arr[0],0,1,$mid);
 }
   }
else {
$rs=mysqli_query($dbconnect,"Select * from $tablee where ID=".$upline);

if(mysqli_num_rows($rs)>0) {
 $arr=mysqli_fetch_array($rs);
if($arr[4]>($forcedmatrix-1)) {

$rs1=mysqli_query($dbconnect,"Select * from $tablee where $fquery and ID<>$acountid and MainID=$arr[17] order by ID limit 0,1");
if(mysqli_num_rows($rs1)>0) {
$arr1=mysqli_fetch_array($rs1);
if($arr1[0]==$arr[0]) {
assignreferrals($acountid,newupline($acountid,$upline,$mid),0,1,$mid);
}
else {
if($arr1[4]>($forcedmatrix-1)) {
assignreferrals($acountid,newupline($acountid,$arr1[0],$mid),0,1,$mid);
}
else {
assignreferrals($acountid,$arr1[0],0,1,$mid);
}
}
}
else {
assignreferrals($acountid,newupline($acountid,$upline,$mid),0,1,$mid);
}


}
else {
assignreferrals($acountid,$upline,1,1,$mid);
}
}
else {
$rs=mysqli_query($dbconnect,"select ID from $tablee where Level1<$forcedmatrix and ID <>'$acountid' order by ID limit 0,1");
 if (mysqli_num_rows($rs)>0)
 {
 $arr=mysqli_fetch_array($rs);
 assignreferrals($acountid,$arr[0],0,1,$mid);
 }
}
}

}
else {

$rs=mysqli_query($dbconnect,"select ID from $tablee where Level1<$forcedmatrix and ID <>'$acountid' order by ID limit 0,1");
 if (mysqli_num_rows($rs)>0)
 {
 $arr=mysqli_fetch_array($rs);
 assignreferrals($acountid,$arr[0],0,1,$mid);
 }

}


}
else {
echo "<br><b>Error Creating Matrix Position.</b><br>";
}

mysqli_query($dbconnect,"delete from verifier where ID=$arrmain[0]");
}


mysqli_query($dbconnect,"update cronjobs set active=0");
}


function newupline($acountid,$ref_by,$mid)
{
include "config.php";
$check=0;
$rsm=mysqli_query($dbconnect,"select * from membershiplevels where ID=$mid");
$arrm=mysqli_fetch_array($rsm);
$levels=$arrm[4];
$forcedmatrix=$arrm[5];
$tablee="matrix$mid";
$checkid=0;
//Check for 1st level spillover
$rs=mysqli_query($dbconnect,"select ID from $tablee where Level1<".$forcedmatrix." and ref_by=".$ref_by." and ID<>'$acountid' order by ID limit 0,1");

if(mysqli_num_rows($rs)>0) {
$arr=mysqli_fetch_array($rs);
$check=1;
$checkid=$arr[0];
}

//Check for 2nd level spillover
else {
$rs=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$ref_by." and ID<>'$acountid' order by ID");

while($arr=mysqli_fetch_array($rs)) {
  $rs1=mysqli_query($dbconnect,"select ID from $tablee where Level1<".$forcedmatrix." and ref_by=".$arr[0]." order by ID limit 0,1");

 if(mysqli_num_rows($rs1)>0) {
  $arr1=mysqli_fetch_array($rs1);
if($check==0) {
  $check=1;
  $checkid=$arr1[0];
}
  break;
 }
}//end of while

 //Check for 3rd level spillover
 if($check==0) {
  $rs=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$ref_by." and ID<>'$acountid' order by ID");
  while($arr=mysqli_fetch_array($rs)) {

  $rs1=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr[0]." order by ID");
   while($arr1=mysqli_fetch_array($rs1)) {
   $rs2=mysqli_query($dbconnect,"select ID from $tablee where Level1<".$forcedmatrix." and ref_by=".$arr1[0]." order by ID limit 0,1");

   if(mysqli_num_rows($rs2)>0) {
    $arr2=mysqli_fetch_array($rs2);
if($check==0) {
    $check=1;
    $checkid=$arr2[0];
}
    break;
   }
  }//while closing
 } //while closing  

   //Check for 4th level spillover
   if($check==0) {

  $rs=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$ref_by." and ID<>'$acountid' order by ID");
  while($arr=mysqli_fetch_array($rs)) {

  $rs1=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr[0]." order by ID");
   while($arr1=mysqli_fetch_array($rs1)) {

    $rs2=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr1[0]." order by ID");
     while($arr2=mysqli_fetch_array($rs2)) {
     $rs3=mysqli_query($dbconnect,"select ID from $tablee where Level1<".$forcedmatrix." and ref_by=".$arr2[0]." order by ID limit 0,1");
     if(mysqli_num_rows($rs3)>0) {
      $arr3=mysqli_fetch_array($rs3);
if($check==0) {
      $check=1;
      $checkid=$arr3[0];
}
      break;
     }
   }
  }
 }
     //Check for 5th level spillover
     if($check==0) {
  $rs=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$ref_by." and ID<>'$acountid' order by ID");
  while($arr=mysqli_fetch_array($rs)) {

  $rs1=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr[0]." order by ID");
   while($arr1=mysqli_fetch_array($rs1)) {

    $rs2=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr1[0]." order by ID");
     while($arr2=mysqli_fetch_array($rs2)) {

      $rs3=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr2[0]." order by ID");

       while($arr3=mysqli_fetch_array($rs3)) {
       $rs4=mysqli_query($dbconnect,"select ID from $tablee where Level1<".$forcedmatrix." and ref_by=".$arr3[0]." order by ID limit 0,1");
       if(mysqli_num_rows($rs4)>0) {
        $arr4=mysqli_fetch_array($rs4);
if($check==0) {
        $check=1;
        $checkid=$arr4[0];
}
        break;
       } 
     }
    }
   }
  }
       //Check for 5th level spillover
  if($check==0) {
  $rs=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$ref_by." and ID<>'$acountid' order by ID");
  while($arr=mysqli_fetch_array($rs)) {

  $rs1=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr[0]." order by ID");
   while($arr1=mysqli_fetch_array($rs1)) {

    $rs2=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr1[0]." order by ID");
     while($arr2=mysqli_fetch_array($rs2)) {

      $rs3=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr2[0]." order by ID");
       while($arr3=mysqli_fetch_array($rs3)) {

        $rs4=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr3[0]." order by ID");
         while($arr4=mysqli_fetch_array($rs4)) {

         $rs5=mysqli_query($dbconnect,"select ID from $tablee where Level1<".$forcedmatrix." and ref_by=".$arr4[0]." order by ID limit 0,1");
         if(mysqli_num_rows($rs5)>0) {
          $arr5=mysqli_fetch_array($rs5);
if($check==0) {
          $check=1;
          $checkid=$arr5[0];
}
          break;
         } 
	}
       }
      }
     }
    }
         //Check for 6th level spillover
  if($check==0) {
  $rs=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$ref_by." and ID<>'$acountid' order by ID");
  while($arr=mysqli_fetch_array($rs)) {

  $rs1=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr[0]." order by ID");
   while($arr1=mysqli_fetch_array($rs1)) {

    $rs2=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr1[0]." order by ID");
     while($arr2=mysqli_fetch_array($rs2)) {

      $rs3=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr2[0]." order by ID");
       while($arr3=mysqli_fetch_array($rs3)) {

        $rs4=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr3[0]." order by ID");
         while($arr4=mysqli_fetch_array($rs4)) {

          $rs5=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr4[0]." order by ID");
           while($arr5=mysqli_fetch_array($rs5)) {
           $rs6=mysqli_query($dbconnect,"select ID from $tablee where Level1<".$forcedmatrix." and ref_by=".$arr5[0]." order by ID limit 0,1");
           if(mysqli_num_rows($rs6)>0) {
            $arr6=mysqli_fetch_array($rs6);
if($check==0) {
            $check=1;
            $checkid=$arr6[0];
}
            break;
           } 
	 }
	}
       }
      }
     }
    }
  //Check for 7th level spillover
    if($check==0) {
  $rs=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$ref_by." and ID<>'$acountid' order by ID");
  while($arr=mysqli_fetch_array($rs)) {

  $rs1=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr[0]." order by ID");
   while($arr1=mysqli_fetch_array($rs1)) {

    $rs2=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr1[0]." order by ID");
     while($arr2=mysqli_fetch_array($rs2)) {

      $rs3=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr2[0]." order by ID");
       while($arr3=mysqli_fetch_array($rs3)) {

        $rs4=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr3[0]." order by ID");
         while($arr4=mysqli_fetch_array($rs4)) {

          $rs5=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr4[0]." order by ID");
           while($arr5=mysqli_fetch_array($rs5)) {

            $rs6=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr5[0]." order by ID");
             while($arr6=mysqli_fetch_array($rs6)) {
             $rs7=mysqli_query($dbconnect,"select ID from $tablee where Level1<".$forcedmatrix." and ref_by=".$arr6[0]." order by ID limit 0,1");
             if(mysqli_num_rows($rs7)>0) {
              $arr7=mysqli_fetch_array($rs7);
if($check==0) {
              $check=1;
              $checkid=$arr7[0];
}
              break;
             } 
	    }
	   }
	  }
	 }
	}
       }
      }
             //Check for 8th level spillover
  if($check==0) {
  $rs=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$ref_by." and ID<>'$acountid' order by ID");
  while($arr=mysqli_fetch_array($rs)) {

  $rs1=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr[0]." order by ID");
   while($arr1=mysqli_fetch_array($rs1)) {

    $rs2=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr1[0]." order by ID");
     while($arr2=mysqli_fetch_array($rs2)) {

      $rs3=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr2[0]." order by ID");
       while($arr3=mysqli_fetch_array($rs3)) {

        $rs4=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr3[0]." order by ID");
         while($arr4=mysqli_fetch_array($rs4)) {

          $rs5=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr4[0]." order by ID");
           while($arr5=mysqli_fetch_array($rs5)) {

            $rs6=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr5[0]." order by ID");
             while($arr6=mysqli_fetch_array($rs6)) {

              $rs7=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr6[0]." order by ID");
               while($arr7=mysqli_fetch_array($rs7)) {
               $rs8=mysqli_query($dbconnect,"select ID from $tablee where Level1<".$forcedmatrix." and ref_by=".$arr7[0]." order by ID limit 0,1");
               if(mysqli_num_rows($rs8)>0) {
                $arr8=mysqli_fetch_array($rs8);
if($check==0) {
                $check=1;
                $checkid=$arr8[0];
}
                break;
               } 
	      }
             }
            }
           }
          }
         }
        }
       }

               //Check for 9th level spillover
    if($check==0) {
  $rs=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$ref_by." and ID<>'$acountid' order by ID");
  while($arr=mysqli_fetch_array($rs)) {

  $rs1=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr[0]." order by ID");
   while($arr1=mysqli_fetch_array($rs1)) {

    $rs2=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr1[0]." order by ID");
     while($arr2=mysqli_fetch_array($rs2)) {

      $rs3=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr2[0]." order by ID");
       while($arr3=mysqli_fetch_array($rs3)) {

        $rs4=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr3[0]." order by ID");
         while($arr4=mysqli_fetch_array($rs4)) {

          $rs5=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr4[0]." order by ID");
           while($arr5=mysqli_fetch_array($rs5)) {

            $rs6=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr5[0]." order by ID");
             while($arr6=mysqli_fetch_array($rs6)) {

              $rs7=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr6[0]." order by ID");
               while($arr7=mysqli_fetch_array($rs7)) {

                $rs8=mysqli_query($dbconnect,"select ID from $tablee where ref_by=".$arr7[0]." order by ID");
                 while($arr8=mysqli_fetch_array($rs8)) {
                 $rs9=mysqli_query($dbconnect,"select ID from $tablee where Level1<".$forcedmatrix." and ref_by=".$arr8[0]." order by ID limit 0,1");
                 if(mysqli_num_rows($rs9)>0) {
                  $arr9=mysqli_fetch_array($rs9);
if($check==0) {
                  $check=1;
                  $checkid=$arr9[0];
}
                  break;
                 } 
		}
	       }
              }
             }
            }
           }
          }
	 }
	}
               } // end of 8th spillover else

             } // end of 8th spillover else

           } // end of 7th spillover else

         } // end of 6th spillover else

       } // end of 5th spillover else

     } // end of 5th spillover else

   } // end of 4th spillover else
 } // end of 3rd spillover else


}  //end of else


if($check!=1) {
$rs2=mysqli_query($dbconnect,"select ID from $tablee where Level1<'$forcedmatrix' and ID <>'$acountid' order by ID limit 0,1");

$arr2=mysqli_fetch_array($rs2);
$checkid=$arr2[0];
}
return $checkid;
}


function assignreferrals($acountid,$refid,$status,$level,$mid) {
 include "config.php";
	$cps = new CoinPaymentsAPI();
	$cps->Setup($private_key, $public_key);
$tablee="matrix$mid";
$rsm=mysqli_query($dbconnect,"select * from membershiplevels where ID=$mid");
$arrm=mysqli_fetch_array($rsm);
$mname=$arrm[1];
$fee=$arrm[2];
$matrixtype=$arrm[3];
$levels=$arrm[4];
$forcedmatrix=$arrm[5];
$refbonus=$arrm[84];
$refbonuspaid=$arrm[83];
$payouttype=$arrm[6];
$matrixbonus=$arrm[7];
$matchingbonus=$arrm[8];
$level1=$arrm[9];
$level2=$arrm[10];
$level3=$arrm[11];
$level4=$arrm[12];
$level5=$arrm[13];
$level6=$arrm[14];
$level7=$arrm[15];
$level8=$arrm[16];
$level9=$arrm[17];
$level10=$arrm[18];
$level1m=$arrm[19];
$level2m=$arrm[20];
$level3m=$arrm[21];
$level4m=$arrm[22];
$level5m=$arrm[23];
$level6m=$arrm[24];
$level7m=$arrm[25];
$level8m=$arrm[26];
$level9m=$arrm[27];
$level10m=$arrm[28];
$level1c=$arrm[29];
$level2c=$arrm[30];
$level3c=$arrm[31];
$level4c=$arrm[32];
$level5c=$arrm[33];
$level6c=$arrm[34];
$level7c=$arrm[35];
$level8c=$arrm[36];
$level9c=$arrm[37];
$level10c=$arrm[38];
$level1cm=$arrm[39];
$level2cm=$arrm[40];
$level3cm=$arrm[41];
$level4cm=$arrm[42];
$level5cm=$arrm[43];
$level6cm=$arrm[44];
$level7cm=$arrm[45];
$level8cm=$arrm[46];
$level9cm=$arrm[47];
$level10cm=$arrm[48];

$textcreditsentry=$arrm[49];
$bannercreditsentry=$arrm[50];
$textcreditscycle=$arrm[51];
$bannercreditscycle=$arrm[52];

$reentry=$arrm[53];
$reentrynum=$arrm[54];
$entry1=$arrm[55];
$entry1num=$arrm[56];
$matrixid1=$arrm[57];
$entry2=$arrm[58];
$entry2num=$arrm[59];
$matrixid2=$arrm[60];
$entry3=$arrm[61];
$entry3num=$arrm[62];
$matrixid3=$arrm[63];
$entry4=$arrm[64];
$entry4num=$arrm[65];
$matrixid4=$arrm[66];
$entry5=$arrm[67];
$entry5num=$arrm[68];
$matrixid5=$arrm[69];
$welcomemail=$arrm[70];
$subject1=stripslashes($arrm[71]);
$message1=stripslashes($arrm[72]);
$eformat1=$arrm[73];
$cyclemail=$arrm[74];
$subject2=stripslashes($arrm[75]);
$message2=stripslashes($arrm[76]);
$eformat2=$arrm[77];
$cyclemailsponsor=$arrm[78];
$subject3=stripslashes($arrm[79]);
$message3=stripslashes($arrm[80]);
$eformat3=$arrm[81];

$f1=$forcedmatrix;
$f2=$forcedmatrix*$forcedmatrix;
$f3=$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f4=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f5=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f6=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f7=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f8=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f9=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f10=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;

if($levels==1) $fquery="Level1<$forcedmatrix"; 
elseif($levels==2) $fquery="Level2<$f2";
elseif($levels==3) $fquery="Level3<$f3";
elseif($levels==4) $fquery="Level4<$f4";
elseif($levels==5) $fquery="Level5<$f5";
elseif($levels==6) $fquery="Level6<$f6";
elseif($levels==7) $fquery="Level7<$f7";
elseif($levels==8) $fquery="Level8<$f8";
elseif($levels==9) $fquery="Level9<$f9";
elseif($levels==10) $fquery="Level10<$f10";

if($status==0) {
$rs=mysqli_query($dbconnect,"Update $tablee set ref_by=".$refid." where ID=".$acountid);
}

if($level < ($levels+1)) {
$referralid=0;
$rs=mysqli_query($dbconnect,"Select * from $tablee where ID=".$refid);
if(mysqli_num_rows($rs)>0)
{
$arr=mysqli_fetch_array($rs);
$err=0;
$rsb=mysqli_query($dbconnect,"select * from $tablee where Username='$arr[2]'");
if(mysqli_num_rows($rsb)>0) $err=0;
elseif($nonmatrixmatch==1) $err=0;
else $err=1;

if($level==1) {
mysqli_query($dbconnect,"Update $tablee set Level1=Level1+1 where ID=".$refid);
$arr[4]++;

if($payouttype==2) {
 	$bonus=$level1;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}

	if($level1m>0&&$err==0) {
	 $bonus=$level1m;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==1)&&($arr[4]==$f1)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==3&&$arr[4]==$f1) {
 	$bonus=$level1c;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level1cm>0&&$err==0) {
	 $bonus=$level1cm;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==1)&&($arr[4]==$f1)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==1&&$levels==1&&$arr[4]==$f1) {
 	$bonus=$matrixbonus;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($matchingbonus>0&&$err==0) {
	 $bonus=$matchingbonus;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }

}
}
elseif($level==2) {
mysqli_query($dbconnect,"Update $tablee set Level2=Level2+1 where ID=".$refid);
$arr[5]++;

if($payouttype==2) {
 	$bonus=$level2;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level2m>0&&$err==0) {
	 $bonus=$level2m;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==2)&&($arr[5]==$f2)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==3&&$arr[5]==$f2) {
 	$bonus=$level2c;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level2cm>0&&$err==0) {
	 $bonus=$level2cm;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==2)&&($arr[5]==$f2)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==1&&$levels==2&&$arr[5]==$f2) {
 	$bonus=$matrixbonus;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($matchingbonus>0&&$err==0) {
	 $bonus=$matchingbonus;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	}
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";

	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }

}
}
elseif($level==3) {
mysqli_query($dbconnect,"Update $tablee set Level3=Level3+1 where ID=".$refid);
$arr[6]++;

if($payouttype==2) {
 	$bonus=$level3;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level3m>0&&$err==0) {
	 $bonus=$level3m;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==3)&&($arr[6]==$f3)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==3&&$arr[6]==$f3) {
 	$bonus=$level3c;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level3cm>0&&$err==0) {
	 $bonus=$level3cm;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==3)&&($arr[6]==$f3)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==1&&$levels==3&&$arr[6]==$f3) {
 	$bonus=$matrixbonus;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($matchingbonus>0&&$err==0) {
	 $bonus=$matchingbonus;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }

}
}
elseif($level==4) {
mysqli_query($dbconnect,"Update $tablee set Level4=Level4+1 where ID=".$refid);
$arr[7]++;

if($payouttype==2) {
 	$bonus=$level4;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level4m>0&&$err==0) {
	 $bonus=$level4m;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==4)&&($arr[7]==$f4)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==3&&$arr[7]==$f4) {
 	$bonus=$level4c;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level4cm>0&&$err==0) {
	 $bonus=$level4cm;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==4)&&($arr[7]==$f4)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==1&&$levels==4&&$arr[7]==$f4) {
 	$bonus=$matrixbonus;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($matchingbonus>0&&$err==0) {
	 $bonus=$matchingbonus;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }

}
}
elseif($level==5) {
mysqli_query($dbconnect,"Update $tablee set Level5=Level5+1 where ID=".$refid);
$arr[8]++;

if($payouttype==2) {
 	$bonus=$level5;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level5m>0&&$err==0) {
	 $bonus=$level5m;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==5)&&($arr[8]==$f5)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==3&&$arr[8]==$f5) {
 	$bonus=$level5c;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level5cm>0&&$err==0) {
	 $bonus=$level5cm;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==5)&&($arr[8]==$f5)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==1&&$levels==5&&$arr[8]==$f5) {
 	$bonus=$matrixbonus;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($matchingbonus>0&&$err==0) {
	 $bonus=$matchingbonus;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }

}
}
elseif($level==6) {
mysqli_query($dbconnect,"Update $tablee set Level6=Level6+1 where ID=".$refid);
$arr[9]++;

if($payouttype==2) {
 	$bonus=$level6;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level6m>0&&$err==0) {
	 $bonus=$level6m;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==6)&&($arr[9]==$f6)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==3&&$arr[9]==$f6) {
 	$bonus=$level6c;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level6cm>0&&$err==0) {
	 $bonus=$level6cm;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==6)&&($arr[9]==$f6)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==1&&$levels==6&&$arr[9]==$f6) {
 	$bonus=$matrixbonus;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($matchingbonus>0&&$err==0) {
	 $bonus=$matchingbonus;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }

}
}
elseif($level==7) {
mysqli_query($dbconnect,"Update $tablee set Level7=Level7+1 where ID=".$refid);
$arr[10]++;

if($payouttype==2) {
 	$bonus=$level7;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level7m>0&&$err==0) {
	 $bonus=$level7m;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==7)&&($arr[10]==$f7)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==3&&$arr[10]==$f7) {
 	$bonus=$level7c;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level7cm>0&&$err==0) {
	 $bonus=$level7cm;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==7)&&($arr[10]==$f7)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==1&&$levels==7&&$arr[10]==$f7) {
 	$bonus=$matrixbonus;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($matchingbonus>0&&$err==0) {
	 $bonus=$matchingbonus;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }

}
}
elseif($level==8) {
mysqli_query($dbconnect,"Update $tablee set Level8=Level8+1 where ID=".$refid);
$arr[11]++;

if($payouttype==2) {
 	$bonus=$level8;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level8m>0&&$err==0) {
	 $bonus=$level8m;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==8)&&($arr[11]==$f8)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==3&&$arr[11]==$f8) {
 	$bonus=$level8c;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level8cm>0&&$err==0) {
	 $bonus=$level8cm;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
		if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
}
	if(($levels==8)&&($arr[11]==$f8)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==1&&$levels==8&&$arr[11]==$f8) {
 	$bonus=$matrixbonus;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($matchingbonus>0&&$err==0) {
	 $bonus=$matchingbonus;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }

}
}
elseif($level==9) {
mysqli_query($dbconnect,"Update $tablee set Level9=Level9+1 where ID=".$refid);
$arr[12]++;

if($payouttype==2) {
 	$bonus=$level9;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level9m>0&&$err==0) {
	 $bonus=$level9m;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==9)&&($arr[12]==$f9)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==3&&$arr[12]==$f9) {
 	$bonus=$level9c;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level9cm>0&&$err==0) {
	 $bonus=$level9cm;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==9)&&($arr[12]==$f9)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==1&&$levels==9&&$arr[12]==$f9) {
 	$bonus=$matrixbonus;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($matchingbonus>0&&$err==0) {
	 $bonus=$matchingbonus;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }

}
}
elseif($level==10) {
mysqli_query($dbconnect,"Update $tablee set Level10=Level10+1 where ID=".$refid);
$arr[13]++;

if($payouttype==2) {
 	$bonus=$level10;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level10m>0&&$err==0) {
	 $bonus=$level10m;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==10)&&($arr[13]==$f10)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==3&&$arr[13]==$f10) {
 	$bonus=$level10c;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($level10cm>0&&$err==0) {
	 $bonus=$level10cm;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
	if(($levels==10)&&($arr[13]==$f10)) {
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }
	}
}
elseif($payouttype==1&&$levels==10&&$arr[13]==$f10) {
 	$bonus=$matrixbonus;
	mysqli_query($dbconnect,"update $tablee set Total=Total+$bonus where ID=".$refid);
	mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[1]'");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[1]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[1]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[1]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	if($matchingbonus>0&&$err==0) {
	 $bonus=$matchingbonus;
	 mysqli_query($dbconnect,"update users set Total=Total+$bonus,Unpaid=Unpaid+$bonus where Username='$arr[2]'");
 	 mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$arr[2]',$arr[14],$mid,'$bonus','100% Matching Bonus',now())");
	if($bonus>0) {
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$arr[2]'"));
	$result = $cps->CreateWithdrawal($bonus, 'BTC',$bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$bonus,Paid=Paid+$bonus where Username='$arr[2]'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$arr[2]','Bitcoin: $tid','$bonus',1,now())");
	}
	}
	}
$today=date ( "Y-m-d H:i:s", mktime (date("H"),date("i"),date("s"),date("m"),date("d"),date("Y")));
	mysqli_query($dbconnect,"update $tablee set CDate='$today' where ID=".$refid);
	 mysqli_query($dbconnect,"update users set banners=banners+$bannercreditscycle,textads=textads+$textcreditscycle where Username='$arr[1]'");
	 if($cyclemail==1) {
	  matrixmail($refid,$arr[1],$mid,2);
	 }

	 if($cyclemailsponsor==1&&$err==0) {
	  matrixmail($refid,$arr[2],$mid,3);
	 }

	 print "<b>User: $arr[1] Position ID: $refid has cycled $mname!</b>";
	 if($reentry==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$reentrynum;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$mid,now())");
	 }
	 if($entry1==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry1num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid1,now())");
	 }
	 if($entry2==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry2num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid2,now())");
	 }
	 if($entry3==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry3num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid3,now())");
	 }
	 if($entry4==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry4num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid4,now())");
	 }
	 if($entry5==1&&$arr[1]!="admin") {
	  for($z=1;$z<=$entry5num;$z++) mysqli_query($dbconnect,"insert into verifier(Username,mid,Date) values('$arr[1]',$matrixid5,now())");
	 }

}
}




if($arr[3]!=0) {
$referralid=$arr[3];
}

if($referralid!=0) {
assignreferrals($acountid,$referralid,1,$level+1,$mid);
}

}
}

}//end of function


function joinmatrix($idd,$mid) {
include "config.php";
$tablee="matrix$mid";
$rsm=mysqli_query($dbconnect,"select * from membershiplevels where ID=$mid");
$arrm=mysqli_fetch_array($rsm);
$mname=$arrm[1];
$fee=$arrm[2];
$matrixtype=$arrm[3];
$levels=$arrm[4];
$forcedmatrix=$arrm[5];
$refbonus=$arrm[84];
$refbonuspaid=$arrm[83];
$payouttype=$arrm[6];
$matrixbonus=$arrm[7];
$matchingbonus=$arrm[8];
$level1=$arrm[9];
$level2=$arrm[10];
$level3=$arrm[11];
$level4=$arrm[12];
$level5=$arrm[13];
$level6=$arrm[14];
$level7=$arrm[15];
$level8=$arrm[16];
$level9=$arrm[17];
$level10=$arrm[18];
$level1m=$arrm[19];
$level2m=$arrm[20];
$level3m=$arrm[21];
$level4m=$arrm[22];
$level5m=$arrm[23];
$level6m=$arrm[24];
$level7m=$arrm[25];
$level8m=$arrm[26];
$level9m=$arrm[27];
$level10m=$arrm[28];
$level1c=$arrm[29];
$level2c=$arrm[30];
$level3c=$arrm[31];
$level4c=$arrm[32];
$level5c=$arrm[33];
$level6c=$arrm[34];
$level7c=$arrm[35];
$level8c=$arrm[36];
$level9c=$arrm[37];
$level10c=$arrm[38];
$level1cm=$arrm[39];
$level2cm=$arrm[40];
$level3cm=$arrm[41];
$level4cm=$arrm[42];
$level5cm=$arrm[43];
$level6cm=$arrm[44];
$level7cm=$arrm[45];
$level8cm=$arrm[46];
$level9cm=$arrm[47];
$level10cm=$arrm[48];

$textcreditsentry=$arrm[49];
$bannercreditsentry=$arrm[50];
$textcreditscycle=$arrm[51];
$bannercreditscycle=$arrm[52];

$reentry=$arrm[53];
$reentrynum=$arrm[54];
$entry1=$arrm[55];
$entry1num=$arrm[56];
$matrixid1=$arrm[57];
$entry2=$arrm[58];
$entry2num=$arrm[59];
$matrixid2=$arrm[60];
$entry3=$arrm[61];
$entry3num=$arrm[62];
$matrixid3=$arrm[63];
$entry4=$arrm[64];
$entry4num=$arrm[65];
$matrixid4=$arrm[66];
$entry5=$arrm[67];
$entry5num=$arrm[68];
$matrixid5=$arrm[69];
$welcomemail=$arrm[70];
$subject1=stripslashes($arrm[71]);
$message1=stripslashes($arrm[72]);
$eformat1=$arrm[73];
$cyclemail=$arrm[74];
$subject2=stripslashes($arrm[75]);
$message2=stripslashes($arrm[76]);
$eformat2=$arrm[77];
$cyclemailsponsor=$arrm[78];
$subject3=stripslashes($arrm[79]);
$message3=stripslashes($arrm[80]);
$eformat3=$arrm[81];

$f1=$forcedmatrix;
$f2=$forcedmatrix*$forcedmatrix;
$f3=$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f4=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f5=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f6=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f7=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f8=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f9=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;
$f10=$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix*$forcedmatrix;

if($levels==1) $fquery="Level1<$forcedmatrix"; 
elseif($levels==2) $fquery="Level2<$f2";
elseif($levels==3) $fquery="Level3<$f3";
elseif($levels==4) $fquery="Level4<$f4";
elseif($levels==5) $fquery="Level5<$f5";
elseif($levels==6) $fquery="Level6<$f6";
elseif($levels==7) $fquery="Level7<$f7";
elseif($levels==8) $fquery="Level8<$f8";
elseif($levels==9) $fquery="Level9<$f9";
elseif($levels==10) $fquery="Level10<$f10";

$upline=0;
$rsm=mysqli_query($dbconnect,"select ID from membershiplevels order by ID desc");
while($arrm=mysqli_fetch_array($rsm)) {
$rs1=mysqli_query($dbconnect,"select * from matrix$arrm[0] where MainID=$idd");
if(mysqli_num_rows($rs1)>0) {
$arr1=mysqli_fetch_array($rs1);
for ($i=1; $i<=17; $i=$i+1) {
$a[$i]=$arr1[$i];
}
$user=$a[1];
$ref_by=$a[2];
if($mid==$arrm[0]) $upline=$a[14];
$urid=$a[17];
}
}

$upline=0;
if($allowlookupforsponsor==1) {
$rsp=mysqli_query($dbconnect,"select ID from $tablee where Username='$ref_by' order by ID limit 0,1");
if(mysqli_num_rows($rsp)>0) {
$arrp=mysqli_fetch_array($rsp);
$upline=$arrp[0];
} else {
$rssp1=mysqli_query($dbconnect,"select Username,ref_by,status from users where Username='$ref_by'");
if(mysqli_num_rows($rssp1)>0) {
$arrsp1=mysqli_fetch_array($rssp1);
$rsp=mysqli_query($dbconnect,"select ID from $tablee where Username='$arrsp1[0]' order by ID limit 0,1");
if(($arrsp1[2]==2)&&(mysqli_num_rows($rsp)>0)) {
$arrp=mysqli_fetch_array($rsp);
$upline=$arrp[0];
} else {
$rssp1=mysqli_query($dbconnect,"select Username,ref_by,status from users where Username='$arrsp1[1]'");
if(mysqli_num_rows($rssp1)>0) {
$arrsp1=mysqli_fetch_array($rssp1);
$rsp=mysqli_query($dbconnect,"select ID from $tablee where Username='$arrsp1[0]' order by ID limit 0,1");
if(($arrsp1[2]==2)&&(mysqli_num_rows($rsp)>0)) {
$arrp=mysqli_fetch_array($rsp);
$upline=$arrp[0];
} else {
$rssp1=mysqli_query($dbconnect,"select Username,ref_by,status from users where Username='$arrsp1[1]'");
if(mysqli_num_rows($rssp1)>0) {
$arrsp1=mysqli_fetch_array($rssp1);
$rsp=mysqli_query($dbconnect,"select ID from $tablee where Username='$arrsp1[0]' order by ID limit 0,1");
if(($arrsp1[2]==2)&&(mysqli_num_rows($rsp)>0)) {
$arrp=mysqli_fetch_array($rsp);
$upline=$arrp[0];
} else {
$rssp1=mysqli_query($dbconnect,"select Username,ref_by,status from users where Username='$arrsp1[1]'");
if(mysqli_num_rows($rssp1)>0) {
$arrsp1=mysqli_fetch_array($rssp1);
$rsp=mysqli_query($dbconnect,"select ID from $tablee where Username='$arrsp1[0]' order by ID limit 0,1");
if(($arrsp1[2]==2)&&(mysqli_num_rows($rsp)>0)) {
$arrp=mysqli_fetch_array($rsp);
$upline=$arrp[0];
} else {
}
}
}
}
}
}

}
}
}
} else {
$rsp=mysqli_query($dbconnect,"select ID from $tablee where Username='$ref_by' order by ID limit 0,1");
if(mysqli_num_rows($rsp)>0) {
$arrp=mysqli_fetch_array($rsp);
$upline=$arrp[0];
}
}

mysqli_query($dbconnect,"insert into $tablee(Username,Sponsor,ref_by,Level1,Level2,Level3,Level4,Level5,Level6,Level7,Level8,Level9,Level10,Leader,Total,Date,MainID,CDate) values('$user','$ref_by',$upline,0,0,0,0,0,0,0,0,0,0,$upline,0,now(),$urid,now())");
$b=mysqli_insert_id($dbconnect);
if($b>0) {
if($urid==0) mysqli_query($dbconnect,"update $tablee set MainID=$b where ID=$b");
$acountid=$b;
$a[11]=$upline;

mysqli_query($dbconnect,"update users set banners=banners+$bannercreditsentry,textads=textads+$textcreditsentry where Username='$user'");

if($refbonuspaid>1&&$refbonus>0) {
$rsb=mysqli_query($dbconnect,"select status from users where Username='$ref_by'");
if(mysqli_num_rows($rsb)>0) {
$arrb=mysqli_fetch_array($rsb);
if(($arrb[0]==2)||($arrb[0]==1&&$freerefbonus==1)) {
mysqli_query($dbconnect,"update users set Total=Total+$refbonus,Unpaid=Unpaid+$refbonus where Username='$ref_by'");
mysqli_query($dbconnect,"insert into tlogs(Username,memid,matrix,Amount,purpose,Date) values('$ref_by',$upline,$mid,'$refbonus','Referral Bonus',now())");
	if($refbonus>0) {
	$cps = new CoinPaymentsAPI();
	$cps->Setup($private_key, $public_key);
	$bit=mysqli_fetch_array(mysqli_query($dbconnect,"select BitcoinWallet from users where Username='$ref_by'"));
	$result = $cps->CreateWithdrawal($refbonus, 'BTC', $bit[0],1);
	if ($result[error] == 'ok') {
		$tid=$result[result][id];
		mysqli_query($dbconnect,"update users set Unpaid=Unpaid-$refbonus,Paid=Paid+$refbonus where Username='$ref_by'");
		mysqli_query($dbconnect,"insert into wtransaction(Username,PaymentMode,Amount,approved,Date) values('$ref_by','Bitcoin: $tid','$refbonus',1,now())");
	}
	}
}
}
}

if($welcomemail==1) {
matrixmail($b,$user,$mid,1);
}

if($matrixtype==1) {

    if ($upline==0)
    {
$rs=mysqli_query($dbconnect,"select ID from $tablee where Level1<$forcedmatrix and ID <>'$acountid' order by ID limit 0,1");
 if (mysqli_num_rows($rs)>0)
 {
 $arr=mysqli_fetch_array($rs);
 assignreferrals($acountid,$arr[0],0,1,$mid);
 }
   }
else {
$rs=mysqli_query($dbconnect,"Select * from $tablee where ID=".$upline);

if(mysqli_num_rows($rs)>0) {
 $arr=mysqli_fetch_array($rs);
if($arr[4]>($forcedmatrix-1)) {

$rs1=mysqli_query($dbconnect,"Select * from $tablee where $fquery and ID<>$acountid and MainID=$arr[17] order by ID limit 0,1");
if(mysqli_num_rows($rs1)>0) {
$arr1=mysqli_fetch_array($rs1);
if($arr1[0]==$arr[0]) {
assignreferrals($acountid,newupline($acountid,$upline,$mid),0,1,$mid);
}
else {
if($arr1[4]>($forcedmatrix-1)) {
assignreferrals($acountid,newupline($acountid,$arr1[0],$mid),0,1,$mid);
}
else {
assignreferrals($acountid,$arr1[0],0,1,$mid);
}
}
}
else {
assignreferrals($acountid,newupline($acountid,$upline,$mid),0,1,$mid);
}


}
else {
assignreferrals($acountid,$upline,1,1,$mid);
}
}
else {
$rs=mysqli_query($dbconnect,"select ID from $tablee where Level1<$forcedmatrix and ID <>'$acountid' order by ID limit 0,1");
 if (mysqli_num_rows($rs)>0)
 {
 $arr=mysqli_fetch_array($rs);
 assignreferrals($acountid,$arr[0],0,1,$mid);
 }
}
}

}
else {

$rs=mysqli_query($dbconnect,"select ID from $tablee where Level1<$forcedmatrix and ID <>'$acountid' order by ID limit 0,1");
 if (mysqli_num_rows($rs)>0)
 {
 $arr=mysqli_fetch_array($rs);
 assignreferrals($acountid,$arr[0],0,1,$mid);
 }

}


}
else {
echo "<br><b>Error Creating Matrix Position.</b><br>";
}



}


function matrixmail($b,$user,$mid,$mt) {
include "config.php";
$tuser=$user;
$tablee="matrix$mid";
$rsm=mysqli_query($dbconnect,"select * from membershiplevels where ID=$mid");
$arrm=mysqli_fetch_array($rsm);
$mname=$arrm[1];
$fee=$arrm[2];
$matrixtype=$arrm[3];
$levels=$arrm[4];
$forcedmatrix=$arrm[5];
$refbonus=$arrm[84];
$refbonuspaid=$arrm[83];
$payouttype=$arrm[6];
$matrixbonus=$arrm[7];
$matchingbonus=$arrm[8];
$level1=$arrm[9];
$level2=$arrm[10];
$level3=$arrm[11];
$level4=$arrm[12];
$level5=$arrm[13];
$level6=$arrm[14];
$level7=$arrm[15];
$level8=$arrm[16];
$level9=$arrm[17];
$level10=$arrm[18];
$level1m=$arrm[19];
$level2m=$arrm[20];
$level3m=$arrm[21];
$level4m=$arrm[22];
$level5m=$arrm[23];
$level6m=$arrm[24];
$level7m=$arrm[25];
$level8m=$arrm[26];
$level9m=$arrm[27];
$level10m=$arrm[28];
$level1c=$arrm[29];
$level2c=$arrm[30];
$level3c=$arrm[31];
$level4c=$arrm[32];
$level5c=$arrm[33];
$level6c=$arrm[34];
$level7c=$arrm[35];
$level8c=$arrm[36];
$level9c=$arrm[37];
$level10c=$arrm[38];
$level1cm=$arrm[39];
$level2cm=$arrm[40];
$level3cm=$arrm[41];
$level4cm=$arrm[42];
$level5cm=$arrm[43];
$level6cm=$arrm[44];
$level7cm=$arrm[45];
$level8cm=$arrm[46];
$level9cm=$arrm[47];
$level10cm=$arrm[48];

$textcreditsentry=$arrm[49];
$bannercreditsentry=$arrm[50];
$textcreditscycle=$arrm[51];
$bannercreditscycle=$arrm[52];

$reentry=$arrm[53];
$reentrynum=$arrm[54];
$entry1=$arrm[55];
$entry1num=$arrm[56];
$matrixid1=$arrm[57];
$entry2=$arrm[58];
$entry2num=$arrm[59];
$matrixid2=$arrm[60];
$entry3=$arrm[61];
$entry3num=$arrm[62];
$matrixid3=$arrm[63];
$entry4=$arrm[64];
$entry4num=$arrm[65];
$matrixid4=$arrm[66];
$entry5=$arrm[67];
$entry5num=$arrm[68];
$matrixid5=$arrm[69];
$welcomemail=$arrm[70];
$subject1=stripslashes($arrm[71]);
$message1=stripslashes($arrm[72]);
$eformat1=$arrm[73];
$cyclemail=$arrm[74];
$subject2=stripslashes($arrm[75]);
$message2=stripslashes($arrm[76]);
$eformat2=$arrm[77];
$cyclemailsponsor=$arrm[78];
$subject3=stripslashes($arrm[79]);
$message3=stripslashes($arrm[80]);
$eformat3=$arrm[81];

$err=0;

$rsp=mysqli_query($dbconnect,"select * from $tablee where ID=$b");
if(mysqli_num_rows($rsp)>0) {
$arr1=mysqli_fetch_array($rsp);

$rs=mysqli_query($dbconnect,"select * from users where Username='$arr1[1]'");
if(mysqli_num_rows($rs)>0) {
$arr=mysqli_fetch_array($rs);
$user=$arr[8];
$ref_by=$arr[11];
} else $err=1;

} else $err=1;

if($err==1) {
$rs=mysqli_query($dbconnect,"select * from users where Username='$user'");
if(mysqli_num_rows($rs)>0) {
$arr=mysqli_fetch_array($rs);
$user=$arr[8];
$ref_by=$arr[11];
$err=0;
} else $err=1;
}

$refname="";
if($mt==3) {
$rsp=mysqli_query($dbconnect,"select * from $tablee where ID=$b");
if(mysqli_num_rows($rsp)>0) {
$arr1=mysqli_fetch_array($rsp);

$rs=mysqli_query($dbconnect,"select * from users where Username='$arr1[1]'");
if(mysqli_num_rows($rs)>0) {
$arr=mysqli_fetch_array($rs);
$refname=$arr[1];
}
}
$rs=mysqli_query($dbconnect,"select * from users where Username='$tuser'");
if(mysqli_num_rows($rs)>0) {
$arr=mysqli_fetch_array($rs);
$user=$arr[8];
$ref_by=$arr[11];
$err=0;
}
}


if($mt==1) {
$message1=$message1;
$subject1=$subject1;
$eformat1=$eformat1;
}
elseif($mt==2) {
$message1=$message2;
$subject1=$subject2;
$eformat1=$eformat2;
}
elseif($mt==3) {
$message1=$message3;
$subject1=$subject3;
$eformat1=$eformat3;
}

  $to = $arr[7];

$message1=str_ireplace("{name}","$arr[1]",$message1);
$message1=str_ireplace("{email}","$arr[7]",$message1);
$message1=str_ireplace("{username}","$arr[8]",$message1);
$message1=str_ireplace("{password}","$arr[9]",$message1);
$message1=str_ireplace("{id}","$b",$message1);
$message1=str_ireplace("{matrix}","$mname",$message1);
$message1=str_ireplace("{refname}","$refname",$message1);
$message1=str_ireplace("{sitename}","$sitename",$message1);
$message1=str_ireplace("{siteurl}","$siteurl",$message1);

$subject1=str_ireplace("{name}","$arr[1]",$subject1);
$subject1=str_ireplace("{email}","$arr[7]",$subject1);
$subject1=str_ireplace("{username}","$arr[8]",$subject1);
$subject1=str_ireplace("{password}","$arr[9]",$subject1);
$subject1=str_ireplace("{id}","$b",$subject1);
$subject1=str_ireplace("{matrix}","$mname",$subject1);
$subject1=str_ireplace("{refname}","$refname",$subject1);
$subject1=str_ireplace("{sitename}","$sitename",$subject1);
$subject1=str_ireplace("{siteurl}","$siteurl",$subject1);
      $message=stripslashes($message1);
      $subject=stripslashes($subject1);

$from=$webmasteremail;
    	$header = "From: $sitename<$from>\n";
if($eformat1==1) 
	$header .="Content-type: text/plain; charset=utf-8\n";
else
	$header .="Content-type: text/html; charset=utf-8\n";
	$header .= "Reply-To: <$from>\n";
	$header .= "X-Sender: <$from>\n";
	$header .= "X-Mailer: PHP4\n";
	$header .= "X-Priority: 3\n";
	$header .= "Return-Path: <$from>\n";

if($err==0)  {
	//mail($to,$subject,$message,$header);
	send_mailer($to,$subject,$message,$eformat1,$mailertype,$from);
}
}
echo "<br><b>Process Completed</b><br>";
mysqli_close($dbconnect);
?>