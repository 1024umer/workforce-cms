<?php
$dayLabels = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
$currentYear=(isset($_GET['year'])?$_GET['year']:date('Y'));
$currentMonth=(isset($_GET['month'])?$_GET['month']:date('m'));
$currentDay=0;//date('d');
$currentDate=null;//date('Y-m-d');
$firstDate = strtotime($currentYear.'-'.$currentMonth.'-01');
$daysInMonth=date('t',$firstDate);
$currentMonthName=(date('F', $firstDate));
$numOfweeks = ($daysInMonth%7==0?0:1) + intval($daysInMonth/7);
$monthEndingDay= date('N',strtotime($currentYear.'-'.$currentMonth.'-'.$daysInMonth));
$monthStartDay = date('N',$firstDate);
$naviHref= null;
if($monthEndingDay<$monthStartDay){
    $numOfweeks++;
}
$nextMonth = date('m', strtotime('+1 month', ($firstDate)));
$nextYear = date('Y', strtotime('+1 month', ($firstDate)));
$previousMonth = date('m', strtotime('-1 month', ($firstDate)));
$previousYear = date('Y', strtotime('-1 month', ($firstDate)));
?>
<h3 class="px-3">Birthday Calendar</h3>
<div class="myB">
    <button onclick="getMonthBirthday(<?=$previousMonth?>, <?=$previousYear?>)"><i class="fas fa-arrow-left"></i></button>
    {{$currentMonthName}}-{{$currentYear}}
    <button onclick="getMonthBirthday(<?=$nextMonth?>, <?=$nextYear?>)"><i class="fas fa-arrow-right"></i></button>
</div>
<table class="table">
    <thead>
        <tr>
            @foreach($dayLabels as $dayLabel)
                <th class="text-center">{{$dayLabel}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @for($i=0;$i<$numOfweeks;$i++)
            <tr>
                @for($j=1;$j<=7;$j++)
                    @php
                    $cellNumber = ($i*7+$j);
                    @endphp
                    @if($currentDay==0)
                    @php
                    $firstDayOfTheWeek = date('N',strtotime($currentYear.'-'.$currentMonth.'-01'));
                    if(intval($cellNumber) == intval($firstDayOfTheWeek)){
                        $currentDay=1;
                    }
                    @endphp
                    @endif
                    @php
                    if( ($currentDay!=0)&&($currentDay<=$daysInMonth) ){
                        $currentDate = date('Y-m-d',strtotime($currentYear.'-'.$currentMonth.'-'.($currentDay)));
                        $cellContent = $currentDay;
                        $currentDay++;
                    }else{
                        $currentDate =null;
                        $cellContent=null;
                    }
                    $birthdaysCount = 0;
                    if($cellContent!=null){
                        $birthdaysCount = \App\Models\User::whereDay('date_of_birth', date('d', strtotime($currentDate)))
                        ->where('is_deleted', 0)
                        ->whereMonth('date_of_birth', date('m', strtotime($currentDate)))->count();
                    }
                    @endphp
                    <?php 
                    $strtoPrint = '<td '.($birthdaysCount>0?'onclick="showBirthday(this)"':'').' id="li-'.$currentDate.'" class="text-center '.($cellNumber%7==1?' start ':($cellNumber%7==0?' end ':' ')).
                    ($currentDate==date('Y-m-d')?'current-date':'').($birthdaysCount>0?' has-birthday ':'').($cellContent==null?'mask':'').'">'.$cellContent;
                    if($cellContent!=null&&$birthdaysCount>0){
                        $birthdayData = \App\Models\User::whereDay('date_of_birth', date('d', strtotime($currentDate)))
                        ->where('is_deleted', 0)
                        ->whereMonth('date_of_birth', date('m', strtotime($currentDate)))->get();
                        $strtoPrint.='<ul class="img-birthdays">';
                        foreach($birthdayData as $birthdayDat){
                            $profile = route('user', $birthdayDat->id);
                            // $strtoPrint.='<li class="list-group-item">';
                            $strtoPrint.='<a class="list-group-item list-group-item-action" href="'.$profile.'"><img class="img-avatar" src="'.$birthdayDat->image_url.'" />'.$birthdayDat->name.'</a>';
                            // $strtoPrint.='</li>';
                        }
                        $strtoPrint.='</ul>';
                    }
                    $strtoPrint.='</td>';
                    print $strtoPrint;
                    ?>
                @endfor
            </tr>
        @endfor
    </tbody>
</table>