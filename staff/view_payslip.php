<?php
    ob_start(); // Start output buffering

    include('../includes/session.php');
    include('../includes/config.php');

    require_once('../TCPDF-main/tcpdf.php');

    $sid=intval($_GET['salaryid']);
    $sql = "SELECT tblsalary.id as sid,staff_name,employee_id,entry_time,basic_rate,overtime_pay,holiday_overtime,allowance,full_attendance_award,other_rewards,total_rewards,net_pay,epf,socso,eis,other_deduction,late,total_deduction,actual_wage,withholding_tax,total_salary,method FROM tblsalary WHERE tblsalary.id='$sid'";
    $query = mysqli_query($conn, $sql) or die(mysqli_error($conn));

    while ($row = mysqli_fetch_array($query)) {
        $staff_name = $row['staff_name'];
        $employee_id = $row['employee_id'];
        $entry_time = $row['entry_time']; 
        $basic_rate = $row['basic_rate'];
        $overtime_pay = $row['overtime_pay'];
        $holiday_overtime = $row['holiday_overtime'];
        $allowance = $row['allowance'];
        $full_attendance_award = $row['full_attendance_award'];
        $other_rewards = $row['other_rewards'];
        $total_rewards = $row['total_rewards'];
        $net_pay = $row['net_pay'];
        $epf = $row['epf'];
        $socso = $row['socso'];
        $eis = $row['eis'];
        $other_deduction = $row['other_deduction'];
        $late = $row['late'];
        $total_deduction = $row['total_deduction'];
        $actual_wage = $row['actual_wage'];
        $withholding_tax = $row['withholding_tax'];
        $total_salary = $row['total_salary'];
        $method = $row['method'];
    }

    class PDF extends TCPDF
    {
        public function Header()
        {
            $image_file = K_PATH_IMAGES.'deskapp-logo-white-svg 2.png';
            $this->Image($image_file, 10, 10, 35, '', 'PNG', '', 'C', false, 300, '', false, false, 0, false, false, false);
            $this->Ln(5);
            $this->SetFont('helvetica','B', 14);
            $this->Cell(189, 5, 'NSK Trading (Meru) Sdn Bhd', 0, 1, 'C');
            $this->SetFont('helvetica','', 9);
            $this->Ln(2);
            $this->Cell(189, 3, 'No. 2-32, Jalan Meranti Sutera 1 KU/10, Pekan Meru. 41050 Klang. Selangor.', 0, 1, 'C');
            $this->SetFont('helvetica','B', 14);
            $this->Ln(2);
            $this->Cell(189, 3, 'Generated Payslip', 0, 1, 'C');
        }

        public function Body()
        {
            // Your code here for the Body content
        }

        public function Footer() {
        // Position at 15 mm from bottom
        $this->setY(-15);
        // Set font
        $this->setFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
    }

    ob_end_clean(); // Clean the output buffer

    // create new PDF document
    $pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('NSK Meru e employee');
    $pdf->SetTitle('NSK Meru e employee');
    $pdf->SetSubject('');
    $pdf->SetKeywords('');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $pdf->setFooterData(array(0,64,0), array(0,64,128));

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
    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

    // ---------------------------------------------------------

    // set default font subsetting mode
    $pdf->setFontSubsetting(true);

    // Set font
    $pdf->SetFont('dejavusans', '', 10, '', true);

    // Add a page
    $pdf->AddPage();
    $pdf->Ln(20);
    $html = '
        <table border="1" cellspacing="1" cellpadding="4">
        <tr>
            <th align="center" colspan="2"><strong>Employee Details</strong></th>
        </tr>
        <tr>
            <th align="left" colspan="2">Full Name: '.$staff_name.'</th>
        </tr>
        <tr>
            <th align="left" colspan="2">Employee No: '.$employee_id.'</th>
        </tr>
        <tr>
            <th align="left" colspan="2">Date: '.$entry_time.'</th>
        </tr>
        <tr>
            <th align="center" colspan="2"><strong>Salary Details</strong></th>
        </tr>
        <tr>
            <td colspan="2" align="center"><strong>Payment</strong></td>
        </tr>
        <tr>
            <td>Basic Rate</td>
            <td>'.$basic_rate.'</td>
        </tr>
        <tr>
            <td>Overtime Pay</td>
            <td>'.$overtime_pay.'</td>
        </tr>
        <tr>
            <td>Holiday Overtime</td>
            <td>'.$holiday_overtime.'</td>
        </tr>
        <tr>
            <td>Allowance</td>
            <td>'.$allowance.'</td>
        </tr>
        <tr>
            <td>Full Attendance Award</td>
            <td>'.$full_attendance_award.'</td>
        </tr>
        <tr>
            <td>Other Rewards</td>
            <td>'.$other_rewards.'</td>
        </tr>
        <tr>
            <td>Total Rewards</td>
            <td>'.$total_rewards.'</td>
        </tr>
        <tr>
            <td>Net Pay</td>
            <td>'.$net_pay.'</td>
        </tr>
        <tr>
            <td colspan="2" align="center"><strong>Deductions</strong></td>
        </tr>
        <tr>
            <td>EPF</td>
            <td>'.$epf.'</td>
        </tr>
        <tr>
            <td>SOCSO</td>
            <td>'.$socso.'</td>
        </tr>
        <tr>
            <td>EIS</td>
            <td>'.$eis.'</td>
        </tr>
        <tr>
            <td>Other Deductions</td>
            <td>'.$other_deduction.'</td>
        </tr>
        <tr>
            <td>Late</td>
            <td>'.$late.'</td>
        </tr>
        <tr>
            <td>Total Deductions</td>
            <td>'.$total_deduction.'</td>
        </tr>
        <tr>
            <td colspan="2" align="center"><strong>Summary</strong></td>
        </tr>
        <tr>
            <td>Withholding Tax</td>
            <td>'.$withholding_tax.'</td>
        </tr>
        <tr>
            <td>Total Salary</td>
            <td>'.$total_salary.'</td>
        </tr>
        <tr>
            <td>Payment Method</td>
            <td>'.$method.'</td>
        </tr>
        </table>';

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

 

    // Close and output PDF document
    $pdf->Output('aci_1.pdf', 'I');
?>
