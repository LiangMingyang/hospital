<?php
  ini_set("memory_limit",-1);
  require("../include/tcpdf/tcpdf.php");
  require("../include/tcpdf/tcpdf_config_alt.php");
  require("../include/tcpdf/lang/chi.php");

  function gen_pdf($filename="sheet.pdf",$page='1',$html){
  		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Dreamers');
		$pdf->SetTitle('');
		$pdf->SetSubject('Sheet');
		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "", "");
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		// set some language-dependent strings (optional)
		// ---------------------------------------------------------
		// set font
		$pdf->SetFont('droidsansfallback', '', 10);
		//$pdf->AddPage();
		// add a page
	    $i=0;
			do{
			$pdf->AddPage();
			$pdf->writeHTML($html[$i], true, false, true, false, '');
			$i++;
			}while($i<$page) ;
			$pdf->lastPage();

		
		$pdf->Output($filename, 'D');
  }
  
 
        //gen_pdf($filename,$page_num,$html_arr);
        $filename="zhong.pdf";
		$page_num=1;
		
		
		$html=<<<EOF
		<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
		<div align="center">
			<div style="text-align: center">
				<h1>北京第三人民医院预约单</h1>
			</div>
			<div id="content" align="center">
				<table cols="6" style="text-align: left">
					<tr>
						<td width="70px">
							<span>预约科室 </span>
						</td>
						<td  width="120px">
							<span class='content_class' id="depart" style="font-weight:700;margin-left:20px;margin-right:30px">
								<u>&nbsp;&nbsp;耳鼻喉科&nbsp;&nbsp;</u>
							</span>
						</td>
						<td width="50px">
							<span>预约号</span>
						</td>
						<td width="70px">
							<span class='content_class' id="reservation_id" style="font-weight:700; margin-left:10px; margin-right:20px">
							<u>&nbsp;&nbsp;1&nbsp;&nbsp;</u>
							</span>
						</td>
						<td width="70px">
							<span>预约时间</span>
						</td>
						<td width="150px">
							<span class='content_class' id="reservation_time" style="font-weight:700; margin-left:10px">
								<u>2014-11-23 09:30</u>
							</span>
						</td>
					</tr>
					<tr>
						<td>
							<span>姓名</span>
						</td>
						<td>
							<span class='content_class' id="name" style="font-weight:700; margin-left:20px; margin-right:100px;">
							<u>&nbsp;&nbsp;耿金坤&nbsp;&nbsp;</u>
							</span>
						</td>
						<td>
							<span>年龄</span>
						</td>
						<td>
							<span class='content_class' id="age" style="font-weight:700; margin-left:10px; margin-right:40px">
							<u>&nbsp;&nbsp;20&nbsp;&nbsp;</u>
							</span>
						</td>
					    <td>
					    	<span>性别</span>
					    </td>
					    <td>
					    	<span class='content_class' id="sex" style="font-weight:700; margin-left:10px">
							<u>&nbsp;&nbsp;男&nbsp;&nbsp;</u>
							</span>
					    </td>
					</tr>
					<tr>
						<td colspan="6">
							<span>症状摘要</span>
						</td>
					</tr>
					<tr >
						<td colspan="6" min-height="300px">
						<br/><br/>
						 <table  border="1" width="500px" min-height="300px">
								<tr >
									<td ><br/><br/>
						    			关于Dreamweaver与HTML编码方式：关于Dreamweaver与HTML编码方式：关于Dreamweaver与HTML编码方式：关于Dreamweaver与HTML编码方式：关于Dreamweaver与HTML编码方式：关于Dreamweaver与HTML编码方式：关于Dreamweaver与HTML编码方式：关于Dreamweaver与HTML编码方式：关于Dreamweaver与HTML编码方式：
									<br/></td>
								</tr>
						 </table>		
								
						</td>
					</tr>
					<tr>
						<td colspan="6">
							<span id="addr_tag" style="font-size: 10px">医院地址:&nbsp;&nbsp;&nbsp;</span>
				            <span id="addr" style="font-size: 10px">北京市海淀区学院路38号</span>
						</td>
						
					</tr>
				</table>
			</div>
			
		</div>
	</body>
</html>


EOF;
		
		 /*
		$html=<<<EOF
		<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>

	<body>
		<div>
			<div style="text-align: center">
				<h1>北京第三人民医院挂号单</h1>
			</div>
			<div id="content">
				<div>
				<table cellspacing=0 cellpadding=0 >
							<tr style="background-color: #000000">
								<td style="text-align: left;background-color: white" width="40px">序号</td>
								<td style="text-align: left;background-color: white" width="100px">1</td>
								<td style="text-align: right;background-color: white" width="420px">温馨提示:您的就诊时间为：2014-11-23 09:30</td>
							</tr>
				</table>
	            <br />
				<table id="back_tb" border="1" style="margin-left: 30px"  cellspacing=0 cellpadding=0 >
							<tr>
								<td style="text-align: center" width="80px">身份证号</td>
								<td style="text-align: center" width="160px">371581199409060051</td>
								<td style="text-align: center" width="80px">姓名</td>
								<td style="text-align: center" width="80px">耿金坤</td>
								<td style="text-align: center" width="80px">性别</td>
								<td style="text-align: center" width="80px">男</td>
							</tr>
							<tr>
								<td style="text-align: center" width="80px">现金支付(￥)</td>
								<td style="text-align: center" width="160px">&nbsp;0.00&nbsp;</td>
								<td style="text-align: center" width="80px">卡支付(￥)</td>
								<td style="text-align: center" width="80px">&nbsp;0.00&nbsp;</td>
								<td style="text-align: center" width="80px">网上支付(￥)</td>
								<td style="text-align: center" width="80px">&nbsp;8.00&nbsp;</td>
							</tr>
						
				</table>
				
        	
				<br /><br />
				<table cellspacing=0 cellpadding=0 >
							<tr style="background-color: #000000">
								<td style="text-align: left;background-color: white;font-size: 10px" width="40px">号别:</td>
								<td style="text-align: left;background-color: white;font-size: 10px" width="150px">内科一级医师</td>
								<td style="text-align: left;background-color: white;font-size: 10px" width="40px">医生:</td>
								<td style="text-align: left;background-color: white;font-size: 10px" width="150px">耿金坤</td>
							</tr>
				</table>
				<br />
			
				<span>_____________________________________________________________________________________________________________________</span>
		
				<br />
				
				<table cellspacing=0 cellpadding=0 >
							<tr style="background-color: #000000">
								<td style="text-align: left;background-color: white;font-size: 10px" width="50px">医院地址:</td>
								<td style="text-align: left;background-color: white;font-size: 10px" width="510px">北京市海淀区学院路38号</td>
							</tr>
							<tr style="background-color: #000000">
								<td style="text-align: left;background-color: white;font-size: 10px" width="140px">预约已付费：预约平台</td>
								<td style="text-align: left;background-color: white;font-size: 10px" width="40px"></td>
								<td style="text-align: left;background-color: white;font-size: 10px" width="380px">2014-11-30  09:30:56</td>
							</tr>
				</table>
			</div>
	</body>
</html>
EOF;
		  * 
		  */
		$html_arr[0]=$html;
        //gen_pdf($filename,$page_num,$html_arr);
?>