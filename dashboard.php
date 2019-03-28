<?php
if(!isset($_COOKIE['USER']))
	header("location: index.php");
$page="Dashboard";
include("header.php");
include("db.php");
$query="SELECT No_tweets, No_airlines, No_positive_tweets, No_negative_tweets FROM `analysisinfo`;";
$analysis_row=mysqli_fetch_assoc(mysqli_query($con,$query));

$query="SELECT id,airline_name,sentiment, COUNT(Id) as tweet_number, SUM(IF (sentiment = -1, 1, 0))*-1 as negative, SUM(IF (sentiment = 1, 1, 0)) as postive  FROM `tweet` GROUP BY Airline_name;";
$tweet_table = mysqli_fetch_all(mysqli_query($con,$query));

$query="SELECT id,tweet_text, No_positive FROM `tweet` ORDER BY No_positive DESC LIMIT 5;";
$postive_tweets_5 = mysqli_fetch_all(mysqli_query($con,$query));
$query="SELECT id,tweet_text, No_Negative FROM `tweet` ORDER BY No_negative DESC LIMIT 5;";
$negative_tweets_5 = mysqli_fetch_all(mysqli_query($con,$query));
for($i = 0;$i < sizeof($tweet_table);$i++)
{
	$tweet_table[$i][4] = round($tweet_table[$i][4]/$tweet_table[$i][3]*100,2);
	$tweet_table[$i][5] = round($tweet_table[$i][5]/$tweet_table[$i][3]*100,2);
}



$query="SELECT COUNT(ID)  FROM loan WHERE YEARWEEK(DATE)=YEARWEEK(NOW());";
//$weekLoaned=mysqli_fetch_assoc(mysqli_query($con,$query))["COUNT(ID)"];
$query="SELECT COUNT(ID) FROM loan WHERE EXTRACT(YEAR_MONTH FROM DATE) = EXTRACT(YEAR_MONTH FROM NOW());";
//$monthLoaned=mysqli_fetch_assoc(mysqli_query($con,$query))['COUNT(ID)'];
$query="SELECT COUNT(DISTINCT studentid) AS students  FROM `loan` ;;";
//$studentNum=mysqli_fetch_assoc(mysqli_query($con,$query))['students'];
$query="SELECT  book.isbn,book.title,book.image, COUNT(bookISBN)AS loanedNum FROM 
loan inner JOIN book ON loan.bookISBN=book.isbn
GROUP BY bookISBN
ORDER BY loanedNum DESC
LIMIT 5;";
$result=mysqli_query($con,$query);
$trendingBks=array();

$query="SELECT loan.id , book.title,studentName, DATE_FORMAT(DATE,'%l:%i %p') AS TIME , DATE_FORMAT(DATE , '%d %M %Y') AS date FROM
loan INNER JOIN book ON loan.bookISBN = book.isbn ORDER BY loan.date DESC LIMIT 5;";
$result=mysqli_query($con,$query);
$recent=array();

$query="SELECT DATE_FORMAT(DATE,'%c') AS MONTH , COUNT(ID) AS VALUE FROM loan WHERE DATE_FORMAT(DATE,'%Y') ='2017' GROUP BY DATE_FORMAT(DATE,'%c') ORDER BY DATE ASC;";
$result=mysqli_query($con,$query);
for($i=1;$i<=12;$i++)
	$yearLoaned[$i]=0;
//while($row=mysqli_fetch_array($result))
{
//	$yearLoaned[$row['MONTH']]=$row['VALUE'];
}
?>

          <!-- Dashboard Counts Section-->
          <section class="dashboard-counts no-padding-bottom"style="padding-top: 20px">
            <div class="container-fluid">
              <div class="row bg-white has-shadow">
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-violet"><i class="icon-bars"></i></div>
                    <div class="title"><span>Total<br>Twees</span>
                    </div>
                    <div class="number"><strong><?php echo $analysis_row['No_tweets'];?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-red"><i class="icon-padnote"></i></div>
                    <div class="title"><span>Total<br>Airlines</span>
                    </div>
                    <div class="number"><strong><?php echo $analysis_row['No_airlines'];?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-green"><i class="icon-list-1"></i></div>
                    <div class="title"><span>Positive<br>Tweets</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 50%; height: 4px;" class="progress-bar bg-green"></div>
                      </div>
                    </div>
                    <div class="number"><strong><?php echo $analysis_row['No_positive_tweets'];?></strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-3 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-orange"><i class="icon-check"></i></div>
                    <div class="title"><span>Negative<br>Tweets</span>
                    </div>
                  <div class="number"><strong><?php echo $analysis_row['No_negative_tweets'];?></strong></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- Dashboard Header Section    -->
          <section class="dashboard-header"style="padding-top: 20px">
            <div class="container-fluid">
              <div class="row">
                <!-- Statistics  ""-->
                <div class="statistics col-lg-3 col-12" style="margin-right: none;" >
                
                <div class="" style="background-color: white;width: 250px;height:590px;margin-right: px;">
                <div style="margin-left:30px; ">
                <h1 style="margin-left:40px;;height: 30px;padding-top:10px"><strong>Airlines</strong></h1>
                     <P style="margin-left:50px;color:#EC7063;margin-left: 0px;color:red;width: 200px;font-size: 8px;margin-bottom:0px;"><strong><em>*To better result, please select more airlines</em></strong></P>
    
            <form name="selected_airlines" onsubmit="return noo()" method="post">
                    <table cellpadding="4px"  >
                        
                        <tr>
                            <th >
                             <input  type="checkbox" class="airline" style="margin-right: 20px;" value="0" name="Singapore" onclick="return validate_selections()" <?php if(in_array('0', explode(',',$_COOKIE['USER'])))echo 'checked';?>/>
                            </th>
                          
                             <td>
                                <img src="img/air/s11.jpg" width="120 px" height="40px">
                            </td>
                        </tr>
                          <tr>
                           
                            <th>
                               <input type="checkbox" class="airline" name="Japan" onclick="return validate_selections()" value="1" <?php if(in_array('1', explode(',',$_COOKIE['USER'])))echo 'checked';?>/>
                            </th>
                          
                             <td>
                                <img src="img/air/9.jpg" width="120 px" height="40px">
                            </td>
                        </tr>
                                      
                             <tr>
                           
                            <th>
                                <input type="checkbox" class="airline" name="Emirates" onclick="return validate_selections()" value = "2" <?php if(in_array('2', explode(',',$_COOKIE['USER'])))echo 'checked';?>/>
                            </th>
                          
                             <td>
                                <img src="img/air/8.png" width="120 px" height="40px">
                            </td>
                        </tr>
                                      
                             <tr>
                           
                            <th>
                                <input type="checkbox" class="airline" name="Cathay" onclick="return validate_selections()" value = "3" <?php if(in_array('3', explode(',',$_COOKIE['USER'])))echo 'checked';?>/>
                            </th>
                          
                             <td>
                                <img src="img/air/7.png" width="120 px" height="40px">
                            </td>
                        </tr>
                                      
                                 <tr>
                           
                            <th>
                                <input type="checkbox" class="airline" name="EVA Air" onclick="return validate_selections()" value="4" <?php if(in_array('4', explode(',',$_COOKIE['USER'])))echo 'checked';?>/>
                            </th>
                           
                             <td>
                                <img src="img/air/6.jpg" width="120 px" height="40px">
                            </td>
                        </tr>
                                      
                             <tr>
                           
                            <th>
                                <input type="checkbox" class="airline" name="Etihad" onclick="return validate_selections()" value="5" <?php if(in_array('5', explode(',',$_COOKIE['USER'])))echo 'checked';?>/>
                            </th>
                            
                             <td>
                                <img src="img/air/5.jpg" width="120 px" height="40px">
                            </td>
                        </tr>                                                                                                                                              
                         <tr>
                           
                            <th>
                              <input type="checkbox" class="airline" name="Lufthansa" onclick="return validate_selections()" value="6" <?php if(in_array('6', explode(',',$_COOKIE['USER'])))echo 'checked';?>/>
                            </th>
                             <td>
                                <img src="img/air/4.png" width="120 px" height="40px">
                            </td>
                        </tr>
                                                     
                         <tr>
                           
                            <th>
                              <input type="checkbox" class="airline" name="Oman" value="7" onclick="return validate_selections()" <?php if(in_array('7', explode(',',$_COOKIE['USER'])))echo 'checked';?>/>
                            </th>
                          
                             <td>
                                <img src="img/air/oman333.jpg" width="120 px" height="40px">
                            </td>
                        </tr>
                        
                             <tr>
                           
                            <th>
                                <input type="checkbox" class="airline" name="Saudi" onclick="return validate_selections()" value="8" <?php if(in_array('8', explode(',',$_COOKIE['USER'])))echo 'checked';?>/>
                            </th>
                           
                             <td>
                                <img src="img/air/2.jpg" width="120 px" height="40px">
                            </td>
                        </tr>
                        
                         <tr>
                           
                            <th>
                                <input type="checkbox" class="airline" name="Royal" onclick="return validate_selections()" value="9" <?php if(in_array('9', explode(',',$_COOKIE['USER'])))echo 'checked';?>/>
                            </th>
                           
                             <td>
                                <img src="img/air/1morro.png" width="120 px" height="40px">
                            </td>
                        </tr> 
                                                                             
                    </table>
<div style="margin-top:5px;  ">
                    <input type="submit" id="submitbtn" class="btn btn-primary" disabled="" onclick="load_page()" style="width: 180px; height:33px;" value="Analyze"></div>
<!--                    <input type="submit" id="submitbtn" class="btn btn-primary" disabled style="width: 150px;" value="Analyze">-->
			</form>
    </div>
    
</div>
                
            
                </div>
                <!-- Bar Chart   -->               
                <div class="chart col-lg-6 col-12"  >
                  <div class="" style="background: white;width: 520px;height: 590px;margin-right: 20px;">
                      <div class="title" style="font-size: 1.3rem;"><h2><strong>Top Positive & Negative airlines</strong></h2></div>
                    <canvas id="barChartHome" style="width: 520px;height: 480px;display: block;margin-right: 0px;padding-left: 0px;margin-top: 35px;"></canvas>
                  </div>
                </div>
                <div class="chart col-lg-3 col-12" style="margin-bottom: 0px;" >
                  <div class="work-amount card" style="
    margin-bottom: 0px;
">
                     <div class="card-body" style=" height: 590px;" style="
    margin-bottom: 0px;
">
                 
                      <h2 style="margin-top: 30px; font-size: 1.3rem; "><strong>Number of Best Airline:</strong></h2>
                      <nav>
                          <ol>
                             <?php
							  		$avg = sizeof($tweet_table)/2;
									$fit = $tweet_table;
									for($i = 0 ;$i < $avg && $i < 3;$i++)
									{
										$max = -1;
										$index = 0;
										for($j = 0 ;$j < sizeof($fit);$j++)
										{
											if($max < $fit[$j][5])
											{
												$max = $fit[$j][5];
												$index = $j;
											}
										}
										echo '<li>',explode("_",$fit[$index][1])[0],'</li>';
										$fit[$index][5] = -10000;
									}
									?>
                          </ol>
                          
                          
                      </nav><br><br>
                      <h2 font-size: 1.3rem;><strong>Number of Worst Airline:</strong></h2>
                      <nav>
                          <ol>
							  <?php
									$avg = sizeof($tweet_table)/2;
									$fit = $tweet_table;
									for($i = 0 ;$i < $avg && $i < 3;$i++)
									{
										$min = 1;
										$index = 0;
										for($j = 0 ;$j < sizeof($fit);$j++)
										{
											if($min > $fit[$j][4])
											{
												$min = $fit[$j][4];
												$index = $j;
											}
										}
										echo '<li>',explode("_",$fit[$index][1])[0],'</li>';
										$fit[$index][4] = 10000;
									}?>
                          </ol>
                          
                          
                      </nav>
                      <div class="chart text-center">

                        <canvas id="pieChart"></canvas>
                      </div>
                    </div>
                   </div>
                </div>
              </div>
            </div>
          </section>
          <!-- Feeds Section-->
          <section class="feeds no-padding-top" style="
    margin-top: 0px;
">
            <div class="container-fluid">
              <div class="row">
                <!-- Pio chart-->
                <div class="col-lg-6">
                  <div class="articles card">
                    <div class="card-header d-flex align-items-center">
                      <div id="chartContainer" style="height: 300px; width: 100%;"></div>
                      <div class="canvasjs-chart-container" style="position: relative; text-align: left; cursor: auto;"><canvas class="canvasjs-chart-canvas" width="475" height="300" style="position: absolute;"></canvas><canvas class="canvasjs-chart-canvas" width="475" height="300" style="position: absolute; -webkit-tap-highlight-color: transparent; cursor: default;"></canvas><div class="canvasjs-chart-toolbar" style="position: absolute; right: 1px; top: 1px; border: 1px solid transparent;"></div><div class="canvasjs-chart-tooltip" style="position: absolute; height: auto; box-shadow: rgba(0, 0, 0, 0.1) 1px 1px 2px 2px; z-index: 1000; pointer-events: none; display: none; border-radius: 5px;"><div style=" width: auto;height: auto;min-width: 50px;line-height: auto;margin: 0px 0px 0px 0px;padding: 5px;font-family: Calibri, Arial, Georgia, serif;font-weight: normal;font-style: italic;font-size: 14px;color: #000000;text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);text-align: left;border: 2px solid gray;background: rgba(255,255,255,.9);text-indent: 0px;white-space: nowrap;border-radius: 5px;-moz-user-select:none;-khtml-user-select: none;-webkit-user-select: none;-ms-user-select: none;user-select: none;} "> Sample Tooltip</div></div></div>
                     
                    </div>
                    </div>
                  
                </div> 
                
                <!-- Check List -->

                <div class="col-lg-6">
                  <div class="recent-activities card">
                    <div class="card-header d-flex align-items-center" style="min-width: 310px; height: 330px;">
                    <img src="img/first_review.png" width="100%" height="100%" >
                    
                    </div>
                    <div class="card-body no-padding">
	
                    </div>
                   
                  </div>
               
                </div>
                  <div class="card-header d-flex align-items-center" style="border-bottom-width: 2px;height: 83px;padding-left: 100px;margin-bottom: 35px;padding-bottom: 10px;width: 98.5%;">
                      <h3 style=" color: black;">help us to improve the system, please select the below tweets to add into database.</h3>
                    </div>
                    <div class="card" style="width:98.5%;">

                  <div class="card-body"style="padding-bottom: 20px;padding-top: 10px;">
                     <table class="table table-striped" style="width:999px; height:px;">
                        <thead >
                          <tr style=" background-color:#2C3E50; color:white; width:400px; height: 30px;">
                            <th style="padding-left: 30px;border-left-width: 20px;padding-bottom: 20px;"><strong>No.</strong></th>
                            <th style="padding-bottom: 20px;padding-left: 12px;"><strong>Tweet <span style=" color: red;"> [to help us, please select Positive tweets]</span></strong></th>
                            <th style="padding-left: 30px;padding-bottom: 20px;"><strong>Positive Sentiment</strong></th>
                             <th style="padding-left: 30px;padding-bottom: 20px;"><img src="img/icon-checkbox.png" width="35px" height="35px"></th>                    
                          </tr>
                        </thead>
                          
                        <tbody class ='positive'>
                         <?php
							$tracking = 0;
							$counter = 5;
							for($i = 0 ;$counter != 0 && $i  < sizeof($postive_tweets_5); $i++)
							{
								$per = round($postive_tweets_5[$i][2]*100,2);
								if($tracking == $per)
									continue;
								$tracking = $per;
								$counter--;
                          		echo "<tr onclick='getFeedback(this)'>";
                            	echo '<th scope="row" style="text-align: center; text-align: center;padding-top: 25px;">'.(5 - $counter).'.</th>';
								echo '<td style="display:none;">'.$postive_tweets_5[$i][0]."</td>";
                            	echo "<td style='width:600px; height: 50px;'>".$postive_tweets_5[$i][1]."</td>";
                            	echo "<td style='text-align: center;text-align: center;padding-top: 25px;'>".$per."%</td>";
                            	echo '<td style="text-align: center;text-align: center;padding-top: 25px;"><input type="checkbox"></td>';
                          		echo '</tr>';
							}
							?>
                          </tbody>
                      </table>
                      
         </div>
                  </div>
                    
                      <div class="card"  style="width:98.5%;">
                   
                   <div class="card-body"style="padding-bottom: 20px;padding-top: 10px;">
                      <table class="table table-striped" style="width:999px; height:px;">
                        <thead >
                          <tr style=" background-color:#2C3E50; color:white;width:600px;">
                            <th Style="padding-left: 30px;border-left-width: 20px;padding-bottom: 20px;"><strong>No.</strong></th>
                            <th style="padding-bottom: 20px;padding-left: 12px;"><strong>Tweet <span style=" color: red;"> [For help us, please select neutral tweets]</span></strong></th>
                            <th style="padding-left: 30px;padding-bottom: 20px;"><strong>Neutral Sentiment</strong></th>
                             <th style="padding-left: 30px;padding-bottom: 20px;"><img src="img/icon-checkbox.png" width="35px" height="35px"></th>
							</tr>
                        </thead>
                          
                        <tbody class='neutral' style="width:600px; height:600px;">
                         <?php
							$tracking = 0;
							$counter = 5;
							for($i = 0 ;$counter != 0 && $i  < sizeof($postive_tweets_5); $i++)
							{
								$per = round($postive_tweets_5[$i][2]*100,2);
								if($tracking == $per)
									continue;
								$tracking = $per;
								$counter--;
                          		echo "<tr onclick='getFeedback(this)' >";
                            	echo '<th scope="row" style="text-align: center;center;padding-top: 25px;">'.(5 - $counter).'.</th>';
								echo "<td style='display:none;'>".$postive_tweets_5[$i][0]."</td>";
                            	echo "<td style='width:600px; height: 50px;'>".$postive_tweets_5[$i][1]."</td>";
                            	echo "<td style='text-align: center;center;padding-top: 25px;'>".$per."%</td>";
                            	echo '<td style="text-align: center;center;padding-top: 25px;"><input type="checkbox"></td>';
                          		echo '</tr>';
							}
							?>
                     </tbody>
                      </table>
                          </div>
                  </div>   
                      <div class="card"  style="width:98.5%;">
                   
                   <div class="card-body"style="padding-bottom: 20px;padding-top: 10px;">
                      <table class="table table-striped" style="width:999px; height:px;">
                        <thead >
                          <tr style=" background-color:#2C3E50; color:white;width:600px;">
                            <th Style="padding-left: 30px;border-left-width: 20px;padding-bottom: 20px;"><strong>No.</strong></th>
                            <th style="padding-bottom: 20px;padding-left: 12px;"><strong>Tweet <span style=" color: red;"> [For help us, please select worst tweets]</span></strong></th>
                            <th style="padding-left: 30px;padding-bottom: 20px;"><strong>Negative Sentiment</strong></th>
                             <th style="padding-left: 30px;padding-bottom: 20px;"><img src="img/icon-checkbox.png" width="35px" height="35px"></th>
							</tr>
                        </thead>
                          
                        <tbody class='negative' style="width:600px; height:600px;">
                          <?php
							$tracking = 0;
							$counter = 5;
							for($i = 0 ;$counter != 0 && $i < sizeof($negative_tweets_5); $i++)
							{
								$per = round($negative_tweets_5[$i][2]*100,2);
								if($tracking == $per)
									continue;
								$tracking = $per;
								$counter--;
                          		echo "<tr onclick='getFeedback(this)' >";
                            	echo '<th scope="row" style="text-align: center;center;padding-top: 25px;">'.(5 - $counter).'.</th>';
								echo "<td style='display:none;' >".$negative_tweets_5[$i][0]."</td>";
                            	echo "<td style='width:600px; height: 50px;' >".$negative_tweets_5[$i][1]."</td>";
                            	echo "<td style='text-align: center;center;padding-top: 25px;'>".$per."%</td>";
                            	echo '<td style="text-align: center;center;padding-top: 25px;"><input type="checkbox"></td>';
                          		echo '</tr>';
							}
							?>
                     </tbody>
                      </table>
                          </div>
                  </div>
              </div>
            </div>
          </section>
          <!--page footer-->
          <?php
			include("footer.php");
			?>
         
          <!-- hmtl code for preload animation-->
		<div class="wrapper">
			<div class="contaner">
				<div class="preloader large">
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
					<span></span>
				</div>
				<div class='ani-text'>Retrieving Live Tweets...</div>
				</div>
				</div>
          
          
    <!-- Javascript files-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <!--<script src="js/charts-home.js"></script>-->
    <script src="js/front.js"></script>
    <script>
    // ------------------------------------------------------- //
    // Bar Chart
    // ------------------------------------------------------ //
    var BARCHARTHOME = $('#barChartHome');
    var barChartHome = new Chart(BARCHARTHOME, {
        type: 'bar',
        options:
        {
            scales:
            {
                xAxes: [{
                    display: true
                }],
                yAxes: [{
                    display: true
                }],
            },
            legend: {
                display: false
            }
        },
        data: {
            labels: [<?php 
							$avg = sizeof($tweet_table)/2;
							$fit = $tweet_table;
							for($i = 0 ;$i < $avg && $i < 3;$i++)
							{
								$max = -1;
								$index = 0;
								for($j = 0 ;$j < sizeof($fit);$j++)
								{
									if($max < $fit[$j][5])
									{
										$max = $fit[$j][5];
										$index = $j;
									}
								}
					 			echo '"'.explode("_",$fit[$index][1])[1],'", ';
								$fit[$index][5] = -10000;
							}
							for($i = 0 ;$i < $avg && $i < 3;$i++)
							{
								$min = 1;
								$index = 0;
								for($j = 0 ;$j < sizeof($fit);$j++)
								{
									if($min > $fit[$j][4])
									{
										$min = $fit[$j][4];
										$index = $j;
									}
								}
					 			echo '"'.explode("_",$fit[$index][1])[1],'", ';
								$fit[$index][4] = 10000;
							}
					 		?>],
            datasets: [
                {










                    label: new Date().getFullYear(),
                    backgroundColor: [
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)'
                    ],
                    borderColor: [
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)',
                        'rgb(121, 106, 238)'
                    ],
                    borderWidth: 1,
			    data: [<?php $avg = sizeof($tweet_table)/2;
							$fit = $tweet_table;
							for($i = 0 ;$i < $avg && $i < 3;$i++)
							{
								$max = -1;
								$index = 0;
								for($j = 0 ;$j < sizeof($fit);$j++)
								{
									if($max < $fit[$j][5])
									{
										$max = $fit[$j][5];
										$index = $j;
									}
								}
					 			echo $fit[$index][5],', ';
								$fit[$index][5] = -10000;
							}
							for($i = 0 ;$i < $avg && $i < 3;$i++)
							{
								$min = 1;
								$index = 0;
								for($j = 0 ;$j < sizeof($fit);$j++)
								{
									if($min > $fit[$j][4])
									{
										$min = $fit[$j][4];
										$index = $j;
									}
								}
					 			echo $fit[$index][4],', ';
								$fit[$index][4] = 10000;
							}?>]
					//data: [10, 14, 52, 32, 32, 45, 36, 98, 35, 12]
                }
            ]
        }
    });
		//for($i = $avg ;$i < $avg+3 && $i < sizeof($tweet_table);$i++)
		window.alert(label);
    </script>
    <script>
window.onload = function () {

var options = {
	title: {
		text: "Tweets Distribution"
	},
	subtitles: [{
		text: "For each Airlines"
	}],
	animationEnabled: true,
	data: [{
		type: "pie",
		startAngle: 0,
		toolTipContent: "<b>{label}</b>: {y}%",
		showInLegend: "true",
		legendText: "{label}",
		indexLabelFontSize: 12,
		indexLabel: "{label}:{y}%",
		dataPoints: [
			<?php 
			foreach($tweet_table as $tweet_row)
			{
				echo "{ y:".round((($tweet_row[3]/$analysis_row['No_tweets'])*100),2).", label: \"".explode("_",$tweet_row[1])[0]."\"},\n";
			}
			?>
			
		]
	}]
};
$("#chartContainer").CanvasJSChart(options);

}
</script>

<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
<script>
	window.addEventListener('load', function(){
	document.getElementsByClassName('canvasjs-chart-credit')[0].style.display = 'none';
}, false);
</script>


<!--<h2>Line chart</h2>-->
<script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="js/analysis_btn.js"></script>
