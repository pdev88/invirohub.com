<?php
   function ValidateEmail($email)
   {
      $pattern = '/^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i';
      return preg_match($pattern, $email);
   }

   if ($_SERVER['REQUEST_METHOD'] == 'POST')
   {
      $mailto = 'Kagiso@invirohub.com';
      $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
      $subject = 'Contact Information';
      $message = 'Values submitted from web site form:';
      $success_url = '';
      $error_url = '';
      $error = '';
      $eol = "\n";
      $max_filesize = isset($_POST['filesize']) ? $_POST['filesize'] * 1024 : 1024000;
      $boundary = md5(uniqid(time()));

      $header  = 'From: '.$mailfrom.$eol;
      $header .= 'Reply-To: '.$mailfrom.$eol;
      $header .= 'MIME-Version: 1.0'.$eol;
      $header .= 'Content-Type: multipart/mixed; boundary="'.$boundary.'"'.$eol;
      $header .= 'X-Mailer: PHP v'.phpversion().$eol;
      if (!ValidateEmail($mailfrom))
      {
         $error .= "The specified email address is invalid!\n<br>";
      }

      if (!empty($error))
      {
         $errorcode = file_get_contents($error_url);
         $replace = "##error##";
         $errorcode = str_replace($replace, $error, $errorcode);
         echo $errorcode;
         exit;
      }

      $internalfields = array ("submit", "reset", "send", "captcha_code");
      $message .= $eol;
      $message .= "IP Address : ";
      $message .= $_SERVER['REMOTE_ADDR'];
      $message .= $eol;
      foreach ($_POST as $key => $value)
      {
         if (!in_array(strtolower($key), $internalfields))
         {
            if (!is_array($value))
            {
               $message .= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
            }
            else
            {
               $message .= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
            }
         }
      }

      $body  = 'This is a multi-part message in MIME format.'.$eol.$eol;
      $body .= '--'.$boundary.$eol;
      $body .= 'Content-Type: text/plain; charset=ISO-8859-1'.$eol;
      $body .= 'Content-Transfer-Encoding: 8bit'.$eol;
      $body .= $eol.stripslashes($message).$eol;
      if (!empty($_FILES))
      {
          foreach ($_FILES as $key => $value)
          {
             if ($_FILES[$key]['error'] == 0 && $_FILES[$key]['size'] <= $max_filesize)
             {
                $body .= '--'.$boundary.$eol;
                $body .= 'Content-Type: '.$_FILES[$key]['type'].'; name='.$_FILES[$key]['name'].$eol;
                $body .= 'Content-Transfer-Encoding: base64'.$eol;
                $body .= 'Content-Disposition: attachment; filename='.$_FILES[$key]['name'].$eol;
                $body .= $eol.chunk_split(base64_encode(file_get_contents($_FILES[$key]['tmp_name']))).$eol;
             }
         }
      }
      $body .= '--'.$boundary.'--'.$eol;
      if ($mailto != '')
      {
         mail($mailto, $subject, $body, $header);
      }
      header('Location: '.$success_url);
      exit;
   }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Downloads</title>
<meta name="generator" content="WYSIWYG Web Builder 9 - http://www.wysiwygwebbuilder.com">
<style type="text/css">
div#container
{
   width: 1422px;
   position: relative;
   margin-top: 0px;
   margin-left: auto;
   margin-right: auto;
   text-align: left;
}
body
{
   text-align: center;
   margin: 0;
   background-color: #FFFFFF;
   background-image: url(images/debut_light_%402X.png);
   color: #000000;
}
</style>
<script type="text/javascript" src="jscookmenu.min.js"></script>
<style type="text/css">
a
{
   color: #F5FFFA;
   text-decoration: none;
}
a:visited
{
   color: #F5FFFA;
}
a:active
{
   color: #FF0000;
}
a:hover
{
   color: #70BF44;
   text-decoration: none;
}
</style>
<style type="text/css">
#wb_Text4 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text4 div
{
   text-align: center;
}
#wb_Text1 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text1 div
{
   text-align: left;
}
#wb_Text3 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text3 div
{
   text-align: left;
}
#wb_Text13 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text13 div
{
   text-align: left;
}
#wb_Text14 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text14 div
{
   text-align: left;
}
#wb_Text19 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text19 div
{
   text-align: left;
}
#wb_Text10 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text10 div
{
   text-align: left;
}
#wb_Text6 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text6 div
{
   text-align: left;
}
#wb_Text9 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text9 div
{
   text-align: left;
}
#wb_Text11 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text11 div
{
   text-align: left;
}
#wb_Text15 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text15 div
{
   text-align: left;
}
#wb_Text16 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text16 div
{
   text-align: left;
}
#wb_Text17 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text17 div
{
   text-align: left;
}
#Header
{
   background-color: #393636;
}
.ThemeMenuBar1Menu,
.ThemeMenuBar1SubMenuTable
{
   font-family: "Century Gothic";
   font-size: 15px;
   font-weight: normal;
   color: #FFFFFF;
   text-align: left;
   padding: 0;
   cursor: pointer;
}
.ThemeMenuBar1MenuOuter
{
   background-color: #393636;
   border: 0;
}
.ThemeMenuBar1SubMenu
{
   position: absolute;
   visibility: hidden;
   border: 0;
   padding: 0;
   border: 0;
}
.ThemeMenuBar1Menu td
{
   padding: 5px 0px 5px 0px;
}
.ThemeMenuBar1SubMenuTable
{
   color: #FFFFFF;
   text-align: left;
   background-color: #70BF44;
   font-weight: normal;
   font-style: normal;
   text-decoration: none;
}
.ThemeMenuBar1SubMenuTable td
{
   white-space: nowrap;
}
.ThemeMenuBar1MainItem
{
}
.ThemeMenuBar1MainItem,
.ThemeMenuBar1MainItemHover,
.ThemeMenuBar1MainItemActive,
.ThemeMenuBar1MenuItem,
.ThemeMenuBar1MenuItemHover,
.ThemeMenuBar1MenuItemActive
{
   white-space: nowrap;
}
.ThemeMenuBar1MenuItem
{
}
.ThemeMenuBar1MainItemHover,
.ThemeMenuBar1MainItemActive
{
   color: #FFFFFF;
   background-color: #70BF44;
   font-weight: normal;
   font-style: normal;
   text-decoration: none;
}
.ThemeMenuBar1MenuItemHover,
.ThemeMenuBar1MenuItemActive
{
   color: #666666;
   background-color: #C0C0C0;
   font-weight: normal;
   font-style: normal;
   text-decoration: none;
}
.ThemeMenuBar1MenuFolderLeft,
.ThemeMenuBar1MenuFolderRight,
.ThemeMenuBar1MenuItemLeft,
.ThemeMenuBar1MenuItemRight
{
   padding: 5px 0px 5px 0px;
}
td.ThemeMenuBar1MainFolderText,
td.ThemeMenuBar1MainItemText
{
   padding: 5px 20px 5px 20px;
}
.ThemeMenuBar1MenuFolderText,
.ThemeMenuBar1MenuItemText
{
   padding: 6px 5px 6px 5px;
}
td.ThemeMenuBar1MenuSplit
{
   overflow: hidden;
   background-color: inherit;
}
div.ThemeMenuBar1MenuSplit
{
   height: 1px;
   margin: 0px 0px 0px 0px;
   overflow: hidden;
   background-color: inherit;
   border-top: 1px solid #6AB644;
}
.ThemeMenuBar1MenuVSplit
{
   display: block;
   width: 1px;
   margin: 0px 22px 0px 22px;
   overflow: hidden;
   background-color: inherit;
   border-right: 1px solid #6AB644;
}
#Image6
{
   border: 0px #000000 solid;
}
#Image3
{
   border: 0px #000000 solid;
}
#Image5
{
   border: 0px #000000 solid;
}
#Layer2
{
   background-color: #393636;
}
.ThemeMenuBar2Menu,
.ThemeMenuBar2SubMenuTable
{
   font-family: Arial;
   font-size: 13px;
   font-weight: normal;
   color: #F5FFFA;
   text-align: center;
   padding: 0;
   cursor: pointer;
}
.ThemeMenuBar2MenuOuter
{
   border: 0;
   width: 307px;
}
.ThemeMenuBar2SubMenu
{
   position: absolute;
   visibility: hidden;
   border: 0;
   padding: 0;
   border: 0;
}
.ThemeMenuBar2Menu td
{
   padding: 0;
}
.ThemeMenuBar2SubMenuTable
{
   color: #666666;
   text-align: left;
   background-color: #EEEEEE;
   font-weight: normal;
   font-style: normal;
   text-decoration: none;
}
.ThemeMenuBar2SubMenuTable td
{
   white-space: nowrap;
}
.ThemeMenuBar2MainItem
{
}
.ThemeMenuBar2MainItem,
.ThemeMenuBar2MainItemHover,
.ThemeMenuBar2MainItemActive,
.ThemeMenuBar2MenuItem,
.ThemeMenuBar2MenuItemHover,
.ThemeMenuBar2MenuItemActive
{
   white-space: nowrap;
}
.ThemeMenuBar2MenuItem
{
}
.ThemeMenuBar2MainItem
{
   background: url(images/img0510.gif);
   width: 307px;
   height: 31px;
   background-repeat: no-repeat;
}
.ThemeMenuBar2MainItemHover,
.ThemeMenuBar2MainItemActive
{
   background: url(images/img0510.gif);
   width: 307px;
   height: 31px;
   background-repeat: no-repeat;
}
.ThemeMenuBar2MainItemHover,
.ThemeMenuBar2MainItemActive
{
   color: #666666;
   font-weight: normal;
   font-style: normal;
   text-decoration: none;
}
.ThemeMenuBar2MenuItemHover,
.ThemeMenuBar2MenuItemActive
{
   color: #666666;
   background-color: #C0C0C0;
   font-weight: normal;
   font-style: normal;
   text-decoration: none;
}
.ThemeMenuBar2MenuFolderLeft,
.ThemeMenuBar2MenuFolderRight,
.ThemeMenuBar2MenuItemLeft,
.ThemeMenuBar2MenuItemRight
{
   padding: 0px 0px 0px 0px;
}
td.ThemeMenuBar2MainFolderText,
td.ThemeMenuBar2MainItemText
{
   padding: 0px 0px 1px 0px;
   width: 307px;
   height: 30px;
}
.ThemeMenuBar2MenuFolderText,
.ThemeMenuBar2MenuItemText
{
   padding: 3px 5px 3px 5px;
}
td.ThemeMenuBar2MainFolderLeft,
td.ThemeMenuBar2MainFolderRight,
td.ThemeMenuBar2MainItemLeft,
td.ThemeMenuBar2MainItemRight
{
   padding: 0px 0px 0px 0px;
}
td.ThemeMenuBar2MenuSplit
{
   overflow: hidden;
   background-color: inherit;
}
div.ThemeMenuBar2MenuSplit
{
   height: 1px;
   margin: 0px 0px 0px 0px;
   overflow: hidden;
   background-color: inherit;
   border-top: 1px solid #666666;
}
.ThemeMenuBar2MenuVSplit
{
   display: block;
   width: 1px;
   margin: 0px 2px 0px 2px;
   overflow: hidden;
   background-color: inherit;
   border-right: 1px solid #666666;
}
#wb_Text2 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text2 div
{
   text-align: center;
}
#wb_Text5 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text5 div
{
   text-align: center;
}
#RollOver1 a
{
   display: block;
   position: relative;
}
#RollOver1 a img
{
   position: absolute;
   z-index: 1;
   border-width: 0px;
}
#RollOver1 span
{
   display: block;
   height: 56px;
   width: 48px;
   position: absolute;
   z-index: 2;
}
#wb_Text7 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text7 div
{
   text-align: center;
}
#Line7
{
   border-width: 0;
   height: 8px;
   width: 215px;
}
#wb_TextMenu2
{
   background-color: transparent;
   color :#000000;
   font-family: Arial;
   font-size: 13px;
}
#wb_TextMenu2 span
{
   display: block;
   margin: 0px 0px 15px 0px;
   line-height: 16px;
}
#Line8
{
   border-width: 0;
   height: 8px;
   width: 215px;
}
#wb_Text12 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: center;
}
#wb_Text12 div
{
   text-align: center;
}
#wb_Form1
{
   background-color: #FAFAFA;
   border: 0px #000000 solid;
}
#wb_Text8 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text8 div
{
   text-align: left;
}
#Combobox1
{
   border: 1px #A9A9A9 solid;
   background-color: #FFFFFF;
   color: #000000;
   font-family: Arial;
   font-size: 13px;
}
#wb_Text18 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text18 div
{
   text-align: left;
}
#Editbox1
{
   border: 1px #A9A9A9 solid;
   background-color: #FFFFFF;
   color :#000000;
   font-family: Arial;
   font-size: 13px;
   text-align: left;
   vertical-align: middle;
}
#wb_Text20 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text20 div
{
   text-align: left;
}
#Editbox2
{
   border: 1px #A9A9A9 solid;
   background-color: #FFFFFF;
   color :#000000;
   font-family: Arial;
   font-size: 13px;
   text-align: left;
   vertical-align: middle;
}
#wb_Text21 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text21 div
{
   text-align: left;
}
#TextArea1
{
   border: 1px #A9A9A9 solid;
   background-color: #FFFFFF;
   color :#000000;
   font-family: Arial;
   font-size: 13px;
   text-align: left;
   resize: none;
}
#wb_Text22 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text22 div
{
   text-align: left;
}
#Editbox3
{
   border: 1px #A9A9A9 solid;
   background-color: #FFFFFF;
   color :#000000;
   font-family: Arial;
   font-size: 13px;
   text-align: left;
   vertical-align: middle;
}
#wb_Text23 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text23 div
{
   text-align: left;
}
#Editbox4
{
   border: 1px #A9A9A9 solid;
   background-color: #FFFFFF;
   color :#000000;
   font-family: Arial;
   font-size: 13px;
   text-align: left;
   vertical-align: middle;
}
#wb_Text24 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text24 div
{
   text-align: left;
}
#Editbox5
{
   border: 1px #A9A9A9 solid;
   background-color: #FFFFFF;
   color :#000000;
   font-family: Arial;
   font-size: 13px;
   text-align: left;
   vertical-align: middle;
}
#wb_Text25 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text25 div
{
   text-align: left;
}
#Editbox6
{
   border: 1px #A9A9A9 solid;
   background-color: #FFFFFF;
   color :#000000;
   font-family: Arial;
   font-size: 13px;
   text-align: left;
   vertical-align: middle;
}
#wb_Text26 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text26 div
{
   text-align: left;
}
#Editbox7
{
   border: 1px #A9A9A9 solid;
   background-color: #FFFFFF;
   color :#000000;
   font-family: Arial;
   font-size: 13px;
   text-align: left;
   vertical-align: middle;
}
#wb_Text27 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text27 div
{
   text-align: left;
}
#Editbox8
{
   border: 1px #A9A9A9 solid;
   background-color: #FFFFFF;
   color :#000000;
   font-family: Arial;
   font-size: 13px;
   text-align: left;
   vertical-align: middle;
}
#wb_Text28 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text28 div
{
   text-align: left;
}
#wb_Text29 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text29 div
{
   text-align: left;
}
#wb_Text30 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text30 div
{
   text-align: left;
}
#wb_Text31 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text31 div
{
   text-align: left;
}
#wb_Text32 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text32 div
{
   text-align: left;
}
#wb_Text33 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text33 div
{
   text-align: left;
}
#wb_Text34 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text34 div
{
   text-align: left;
}
#wb_Text35 
{
   background-color: transparent;
   border: 0px #000000 solid;
   padding: 0;
   text-align: left;
}
#wb_Text35 div
{
   text-align: left;
}
#Button1
{
   border: 1px #A9A9A9 solid;
   background-color: #F0F0F0;
   color: #000000;
   font-family: Arial;
   font-size: 13px;
}
</style>
<script type="text/javascript" src="swfobject.js"></script>
<script type="text/javascript" src="jquery-1.9.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
   $("#RollOver1 a").hover(function()
   {
      $(this).children("span").stop().fadeTo(500, 0);
   }, function()
   {
      $(this).children("span").stop().fadeTo(500, 1);
   });
});
</script>
</head>
<body>
<div id="container">
<div id="wb_Shape10" style="position:absolute;left:352px;top:1098px;width:242px;height:38px;z-index:39;">
<img src="images/img0499.png" id="Shape10" alt="" style="border-width:0;width:242px;height:38px;"></div>
<div id="wb_Shape2" style="position:absolute;left:24px;top:971px;width:14px;height:15px;z-index:40;">
<img src="images/img0500.png" id="Shape2" alt="" style="border-width:0;width:14px;height:15px;"></div>
<div id="wb_Shape6" style="position:absolute;left:0px;top:899px;width:307px;height:38px;z-index:41;">
<img src="images/img0501.png" id="Shape6" alt="" style="border-width:0;width:307px;height:38px;"></div>
<div id="wb_Text4" style="position:absolute;left:24px;top:908px;width:252px;height:21px;text-align:center;z-index:42;">
<span style="color:#FFFFFF;font-family:'Century Gothic';font-size:17px;letter-spacing:0px;">RECENT NEWS</span></div>
<div id="wb_Text1" style="position:absolute;left:756px;top:364px;width:203px;height:19px;z-index:43;text-align:left;">
<span style="color:#FFFFFF;font-family:Arial;font-size:17px;">Single Phase Meters</span></div>
<div id="wb_Shape7" style="position:absolute;left:353px;top:242px;width:244px;height:38px;z-index:44;">
<img src="images/img0502.png" id="Shape7" alt="" style="border-width:0;width:244px;height:38px;"></div>
<div id="wb_Text3" style="position:absolute;left:388px;top:251px;width:192px;height:21px;z-index:45;text-align:left;">
<span style="color:#FFFFFF;font-family:'Century Gothic';font-size:16px;">Company Brochures</span></div>
<div id="wb_Text13" style="position:absolute;left:753px;top:608px;width:203px;height:19px;z-index:46;text-align:left;">
<span style="color:#FFFFFF;font-family:Arial;font-size:17px;">Single Phase Meters</span></div>
<div id="wb_Shape11" style="position:absolute;left:351px;top:570px;width:244px;height:38px;z-index:47;">
<img src="images/img0503.png" id="Shape11" alt="" style="border-width:0;width:244px;height:38px;"></div>
<div id="wb_Text14" style="position:absolute;left:386px;top:579px;width:201px;height:21px;z-index:48;text-align:left;">
<span style="color:#FFFFFF;font-family:'Century Gothic';font-size:16px;">Product Catalogue</span></div>
<div id="wb_Text19" style="position:absolute;left:754px;top:870px;width:203px;height:19px;z-index:49;text-align:left;">
<span style="color:#FFFFFF;font-family:Arial;font-size:17px;">Single Phase Meters</span></div>
<div id="wb_Shape15" style="position:absolute;left:351px;top:710px;width:242px;height:38px;z-index:50;">
<img src="images/img0504.png" id="Shape15" alt="" style="border-width:0;width:242px;height:38px;"></div>
<div id="wb_Text10" style="position:absolute;left:412px;top:718px;width:201px;height:21px;z-index:51;text-align:left;">
<span style="color:#FFFFFF;font-family:'Century Gothic';font-size:16px;">Case Studies</span></div>
<div id="wb_Text6" style="position:absolute;left:351px;top:312px;width:250px;height:187px;z-index:52;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:15px;">1. Company Profile<br><br>2. Product Catalogue<br><br>3. Services Brochure<br><br>4. General Overview Brochure<br><br>5. Commercial &amp; Industrial Brochure<br><br>6. Municipal Brochure</span></div>
<div id="wb_Text9" style="position:absolute;left:351px;top:627px;width:250px;height:54px;z-index:53;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:16px;">1. All Products Catalogue<br><br> </span></div>
<div id="wb_Text11" style="position:absolute;left:351px;top:779px;width:250px;height:54px;z-index:54;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:16px;">1. Case Studies- Elias<br><br>2. Case Study- Southdale</span></div>
<div id="wb_Shape1" style="position:absolute;left:343px;top:912px;width:242px;height:38px;z-index:55;">
<img src="images/img0505.png" id="Shape1" alt="" style="border-width:0;width:242px;height:38px;"></div>
<div id="wb_Text15" style="position:absolute;left:368px;top:922px;width:256px;height:21px;z-index:56;text-align:left;">
<span style="color:#FFFFFF;font-family:'Century Gothic';font-size:16px;">User / Installation Manuals </span></div>
<div id="wb_Text16" style="position:absolute;left:351px;top:978px;width:250px;height:54px;z-index:57;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:16px;">1. Installation Manuals<br><br>2. User manual Vending</span></div>
<div id="wb_Text17" style="position:absolute;left:368px;top:1106px;width:256px;height:21px;z-index:58;text-align:left;">
<span style="color:#FFFFFF;font-family:'Century Gothic';font-size:16px;">Accreditation Certificates</span></div>
<div id="wb_Shape13" style="position:absolute;left:0px;top:132px;width:307px;height:868px;z-index:59;">
<img src="images/img0509.png" id="Shape13" alt="" style="border-width:0;width:307px;height:868px;"></div>
<div id="wb_MenuBar2" style="position:absolute;left:0px;top:212px;width:307px;height:167px;z-index:1060;">
<div id="MenuBar2">
<ul style="display:none;">
<li><span></span><a href="./About_Us.html" target="_self">Mission&nbsp;&amp;&nbsp;Vision</a>
</li>
<li><span></span><a href="./Board_of_directors.html" target="_self">Leadership</a>
</li>
<li><span></span><a href="./Operating_Partners.html" target="_self">Operating&nbsp;Partners</a>
</li>
<li><span></span><a href="./BBBEE.html" target="_self">BBBEE</a>
</li>
<li><span></span><a href="./Socio-Economic_Development.html" target="_self">Socio-Economic&nbsp;Development</a>
</li>
</ul>
</div>
<script type="text/javascript">
var cmMenuBar2 =
{
   mainFolderLeft: '',
   mainFolderRight: '',
   mainItemLeft: '',
   mainItemRight: '',
   folderLeft: '',
   folderRight: '',
   itemLeft: '',
   itemRight: '',
   mainSpacing: 0,
   subSpacing: 0,
   delay: 100,
   offsetVMainAdjust: [1, 0],
   offsetSubAdjust: [0, 0]
};
var cmThemeMenuBar2HSplit = [_cmNoClick, '<td colspan="3" class="ThemeMenuBar2MenuSplit"><div class="ThemeMenuBar2MenuSplit"><\/div><\/td>'];
var cmThemeMenuBar2MainHSplit = [_cmNoClick, '<td colspan="3" class="ThemeMenuBar2MenuSplit"><div class="ThemeMenuBar2MenuSplit"><\/div><\/td>'];
var cmThemeMenuBar2MainVSplit = [_cmNoClick, '<div class="ThemeMenuBar2MenuVSplit">|<\/div>'];

cmDrawFromText('MenuBar2', 'vbr', cmMenuBar2, 'ThemeMenuBar2');
</script>
</div>
<div id="wb_YouTube1" style="position:absolute;left:15px;top:501px;width:276px;height:234px;z-index:61;">
<iframe width="276" height="234" src=" http://www.youtube.com/embed/9g7ZtSev1a8?rel=1&amp;version=3&amp;autohide=0&amp;theme=dark" frameborder="0"></iframe>
</div>
<div id="wb_Shape5" style="position:absolute;left:0px;top:441px;width:307px;height:38px;z-index:62;">
<img src="images/img0511.png" id="Shape5" alt="" style="border-width:0;width:307px;height:38px;"></div>
<div id="wb_Text2" style="position:absolute;left:35px;top:452px;width:237px;height:18px;text-align:center;z-index:63;">
<span style="color:#FFFFFF;font-family:Arial;font-size:16px;letter-spacing:0px;">Energy Saving Tips</span></div>
<div id="wb_Shape12" style="position:absolute;left:0px;top:758px;width:307px;height:38px;z-index:64;">
<img src="images/img0512.png" id="Shape12" alt="" style="border-width:0;width:307px;height:38px;"></div>
<div id="wb_Text5" style="position:absolute;left:70px;top:766px;width:158px;height:19px;text-align:center;z-index:65;">
<span style="color:#FFFFFF;font-family:Arial;font-size:17px;letter-spacing:0px;">Recent News</span></div>
<div id="RollOver1" style="position:absolute;overflow:hidden;left:113px;top:374px;width:48px;height:56px;z-index:66">
<a href="">
<img class="hover" alt="" src="images/back2.png" style="left:0px;top:0px;width:48px;height:56px;">
<span><img alt="" src="images/back.png" style="left:0px;top:0px;width:48px;height:56px"></span>
</a>
</div>
<div id="wb_Text7" style="position:absolute;left:143px;top:396px;width:69px;height:18px;text-align:center;z-index:67;">
<span style="color:#FFFFFF;font-family:Arial;font-size:16px;letter-spacing:0px;">Back</span></div>
<div id="wb_Line7" style="position:absolute;left:51px;top:837px;width:207px;height:0px;z-index:68;">
<img src="images/img0513.png" id="Line7" alt=""></div>
<div id="wb_TextMenu2" style="position:absolute;left:55px;top:817px;width:233px;height:161px;z-index:69;">
<span><a href="http://www.reeep.org/events/8th-southern-african-energy-efficiency-convention-2013-saeec">SAEE Expo</a></span>
<span><a href="http://www.africaelectricity.com/">Africa Electicity Expo</a></span>
<span><a href="http://www.southafrica.com/events/conferences/gauteng/johannesburg/women-in-energy-africa-forum-2013-3338.html">Women in Energy Africa Forum 2013</a></span>
<span><a href="">Bidvest Fun Walk</a></span>
<span><a href="">Cebit Hanover 2013 Expo</a></span>
</div>
<div id="wb_Line8" style="position:absolute;left:51px;top:869px;width:207px;height:0px;z-index:70;">
<img src="images/img0514.png" id="Line8" alt=""></div>
<div id="wb_Shape14" style="position:absolute;left:0px;top:153px;width:307px;height:38px;z-index:71;">
<img src="images/img0515.png" id="Shape14" alt="" style="border-width:0;width:307px;height:38px;"></div>
<div id="wb_Text12" style="position:absolute;left:93px;top:160px;width:125px;height:24px;text-align:center;z-index:72;">
<span style="color:#FFFFFF;font-family:Arial;font-size:21px;letter-spacing:0px;">About Us</span></div>
<div id="wb_Form1" style="position:absolute;left:690px;top:284px;width:356px;height:635px;z-index:73;">
<form name="contact" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="Form1">
<div id="wb_Text8" style="position:absolute;left:10px;top:15px;width:84px;height:16px;z-index:4;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Subject:</span></div>
<select name="subject" size="1" id="Combobox1" style="position:absolute;left:104px;top:15px;width:200px;height:25px;z-index:5;">
<option selected value="General Feedback">General Feedback</option>
<option value="Contact Request">Contact Request</option>
<option value="Price Quote">Price Quote</option>
<option value="Employment Information">Employment Information</option>
</select>
<div id="wb_Text18" style="position:absolute;left:10px;top:45px;width:84px;height:16px;z-index:6;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Name:</span></div>
<input type="text" id="Editbox1" style="position:absolute;left:104px;top:45px;width:198px;height:23px;line-height:23px;z-index:7;" name="name" value="">
<div id="wb_Text20" style="position:absolute;left:10px;top:75px;width:84px;height:16px;z-index:8;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Email:</span></div>
<input type="text" id="Editbox2" style="position:absolute;left:104px;top:75px;width:198px;height:23px;line-height:23px;z-index:9;" name="email" value="">
<div id="wb_Text21" style="position:absolute;left:10px;top:105px;width:84px;height:16px;z-index:10;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Address:</span></div>
<textarea name="Address" id="TextArea1" style="position:absolute;left:104px;top:105px;width:198px;height:98px;z-index:11;" rows="5" cols="27"></textarea>
<div id="wb_Text22" style="position:absolute;left:10px;top:210px;width:84px;height:16px;z-index:12;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">City:</span></div>
<input type="text" id="Editbox3" style="position:absolute;left:104px;top:210px;width:198px;height:23px;line-height:23px;z-index:13;" name="city" value="">
<div id="wb_Text23" style="position:absolute;left:10px;top:240px;width:84px;height:16px;z-index:14;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">State:</span></div>
<input type="text" id="Editbox4" style="position:absolute;left:104px;top:240px;width:198px;height:23px;line-height:23px;z-index:15;" name="state" value="">
<div id="wb_Text24" style="position:absolute;left:10px;top:270px;width:84px;height:16px;z-index:16;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Zip</span></div>
<input type="text" id="Editbox5" style="position:absolute;left:104px;top:270px;width:198px;height:23px;line-height:23px;z-index:17;" name="zip" value="">
<div id="wb_Text25" style="position:absolute;left:10px;top:300px;width:84px;height:16px;z-index:18;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Home Phone:</span></div>
<input type="text" id="Editbox6" style="position:absolute;left:104px;top:300px;width:198px;height:23px;line-height:23px;z-index:19;" name="Home Phone" value="">
<div id="wb_Text26" style="position:absolute;left:10px;top:330px;width:84px;height:16px;z-index:20;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Work Phone</span></div>
<input type="text" id="Editbox7" style="position:absolute;left:104px;top:330px;width:198px;height:23px;line-height:23px;z-index:21;" name="Work Phone" value="">
<div id="wb_Text27" style="position:absolute;left:10px;top:360px;width:84px;height:16px;z-index:22;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Fax Number</span></div>
<input type="text" id="Editbox8" style="position:absolute;left:104px;top:360px;width:198px;height:23px;line-height:23px;z-index:23;" name="Fax Number" value="">
<div id="wb_Text28" style="position:absolute;left:10px;top:390px;width:227px;height:16px;z-index:24;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">When is the best time to contact you?</span></div>
<div id="wb_Text29" style="position:absolute;left:10px;top:415px;width:84px;height:16px;z-index:25;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Morning</span></div>
<input type="radio" id="RadioButton1" name="q[1]" value="Morning" checked style="position:absolute;left:104px;top:415px;z-index:26;">
<div id="wb_Text30" style="position:absolute;left:10px;top:440px;width:84px;height:16px;z-index:27;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Afternoon</span></div>
<input type="radio" id="RadioButton2" name="q[1]" value="Afternoon" style="position:absolute;left:104px;top:440px;z-index:28;">
<div id="wb_Text31" style="position:absolute;left:10px;top:465px;width:84px;height:16px;z-index:29;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Evening</span></div>
<input type="radio" id="RadioButton3" name="q[1]" value="Evening" style="position:absolute;left:104px;top:465px;z-index:30;">
<div id="wb_Text32" style="position:absolute;left:10px;top:490px;width:227px;height:16px;z-index:31;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">What is the best way to contact you?</span></div>
<div id="wb_Text33" style="position:absolute;left:10px;top:515px;width:84px;height:16px;z-index:32;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Phone</span></div>
<input type="radio" id="RadioButton4" name="q[2]" value="Phone" checked style="position:absolute;left:104px;top:515px;z-index:33;">
<div id="wb_Text34" style="position:absolute;left:10px;top:540px;width:84px;height:16px;z-index:34;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">E-mail</span></div>
<input type="radio" id="RadioButton5" name="q[2]" value="E-mail" style="position:absolute;left:104px;top:540px;z-index:35;">
<div id="wb_Text35" style="position:absolute;left:10px;top:565px;width:84px;height:16px;z-index:36;text-align:left;">
<span style="color:#000000;font-family:Arial;font-size:13px;">Fax</span></div>
<input type="radio" id="RadioButton6" name="q[2]" value="Fax" style="position:absolute;left:104px;top:565px;z-index:37;">
<input type="submit" id="Button1" name="" value="Send" style="position:absolute;left:104px;top:590px;width:96px;height:25px;z-index:38;">
</form>
</div>
</div>
<div id="Header" style="position:absolute;text-align:left;left:0%;top:0px;width:100%;height:120px;z-index:74;" title="">
<div id="wb_MenuBar1" style="position:absolute;left:634px;top:59px;width:682px;height:30px;z-index:1000;">
<div id="MenuBar1">
<ul style="display:none;">
<li><span></span><a href="./Index.html" target="_self">Home</a>
</li>
<li><span></span><a href="./About_Us.html" target="_self">About&nbsp;Us</a>

<ul>
<li><span></span><a href="./Board_of_directors.html" target="_self">Leadership</a>
</li>
<li><span></span><a href="./Operating_Partners.html" target="_self">Operating&nbsp;Partners</a>
</li>
<li><span></span><a href="./BBBEE.html" target="_self">BBBEE</a>
</li>
<li><span></span><a href="./Socio-Economic_Development.html" target="_self">Socio-Economic&nbsp;Development</a>
</li>
</ul>
</li>
<li><span></span><a href="./Services.html" target="_self">Services</a>

<ul>
<li><span></span><a href="./AMI.html" target="_self">AMI</a>
</li>
<li><span></span><a href="./Vending,_Billing_&_Tariff_Management.html" target="_self">Vending,&nbsp;Billing&nbsp;&amp;&nbsp;Tariff&nbsp;Management</a>
</li>
<li><span></span><a href="./Profiling,_Reporting_&_Analysis.html" target="_self">Profiling,&nbsp;Reporting&nbsp;&amp;&nbsp;Analysis</a>
</li>
<li><span></span><a href="./Field_Services.html" target="_self">Field&nbsp;Services</a>
</li>
<li><span></span><a href="./Consulting_Services.html" target="_self">Consulting&nbsp;Services</a>
</li>
</ul>
</li>
<li><span></span><a href="./Products.html" target="_self">Products</a>

<ul>
<li><span></span><a href="./Single_Phase_Meters.html" target="_self">Single&nbsp;Phase&nbsp;Meters</a>
</li>
<li><span></span><a href="./Three_Phase_Meters.html" target="_self">Three&nbsp;Phase&nbsp;Meters&nbsp;</a>
</li>
<li><span></span><a href="./Concentrator.html" target="_self">Concentrator</a>
</li>
<li><span></span><a href="./Appliance_Control_Device.html" target="_self">Appliance&nbsp;Control&nbsp;Device</a>
</li>
<li><span></span><a href="./Display_Customer_Interface_Unit_.html" target="_self">Display&nbsp;Customer&nbsp;Interface&nbsp;Unit</a>
</li>
<li><span></span><a href="./Circuit_&_Appliance_Monitoring.html" target="_self">Circuit&nbsp;&amp;&nbsp;Appliance&nbsp;Monitoring</a>
</li>
<li><span></span><a href="./Water_Pulse_Units.html" target="_self">Water&nbsp;Pulse&nbsp;Units</a>
</li>
</ul>
</li>
<li><span></span><span>Tools&nbsp;+&nbsp;Resources</span>
<ul>
<li><span></span><a href="./Downloads.html" target="_self">Downloads&nbsp;</a>
</li>
<li><span></span><span>Become&nbsp;a&nbsp;Distributor/Agent</span></li>
<li><span></span><a href="./Software.html" target="_self">Software</a>
</li>
</ul>
</li>
<li><span></span><a href="./Contact.php" target="_self">Contact&nbsp;Us</a>
</li>
</ul>
</div>
<script type="text/javascript">
var cmMenuBar1 =
{
   mainFolderLeft: '',
   mainFolderRight: '',
   mainItemLeft: '',
   mainItemRight: '',
   folderLeft: '',
   folderRight: '',
   itemLeft: '',
   itemRight: '',
   mainSpacing: 0,
   subSpacing: 0,
   delay: 100,
   offsetHMainAdjust: [0, 0],
   offsetSubAdjust: [0, 0]
};
var cmThemeMenuBar1HSplit = [_cmNoClick, '<td colspan="3" class="ThemeMenuBar1MenuSplit"><div class="ThemeMenuBar1MenuSplit"><\/div><\/td>'];
var cmThemeMenuBar1MainHSplit = [_cmNoClick, '<td colspan="3" class="ThemeMenuBar1MenuSplit"><div class="ThemeMenuBar1MenuSplit"><\/div><\/td>'];
var cmThemeMenuBar1MainVSplit = [_cmNoClick, '<div class="ThemeMenuBar1MenuVSplit">|<\/div>'];

cmMenuBar1.effect = new CMSlidingEffect(8);
cmDrawFromText('MenuBar1', 'hbr', cmMenuBar1, 'ThemeMenuBar1');
</script>
</div>
<div id="wb_Image6" style="position:absolute;left:1322px;top:51px;width:42px;height:42px;z-index:1;">
<a href="http://www.facebook.com/Invirohub"><img src="images/img0506.png" id="Image6" alt="" style="width:42px;height:42px;"></a></div>
<div id="wb_Image3" style="position:absolute;left:214px;top:27px;width:375px;height:74px;z-index:2;">
<img src="images/img0507.png" id="Image3" alt="" style="width:375px;height:74px;"></div>
<div id="wb_Image5" style="position:absolute;left:1375px;top:51px;width:40px;height:41px;z-index:3;">
<a href="http://www.twitter.com/Invirohub"><img src="images/img0508.png" id="Image5" alt="" style="width:40px;height:41px;"></a></div>
</div>
<div id="Layer2" style="position:absolute;text-align:left;left:0%;top:123px;width:100%;height:10px;z-index:75;" title="">
</div>
</body>
</html>