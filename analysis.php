<?php
	if(!isset($_COOKIE['USER']))
	header("location: index.php");
    $page="Analysis";
    include("header.php");    
	include"db.php";

	$query = "SELECT Airline_name, sentiment, COUNT(Id) as tweet_number,COUNT(No_positive) as totale_sentiment FROM `tweet` GROUP BY Airline_name, sentiment;";
	$tweet_table = mysqli_fetch_all(mysqli_query($con,$query));
	$airlines = ['Emirates Airlines_EM', 'Singapore Airlines_SI', 'Japan Airlines_JA', 'Oman Airlines_OM', 'Saudi Arabian Airlines_SAU', 'Cathay Pacifi Airlines_CAT', 'EVA Airlines_EVA', 'Lufthansa Airline_LU', 'Etihad Airways_ET', 'Royal Air Maroc_MAR'];
	$analysis = [];
	for ($i = 0; $i < sizeof($airlines) ; $i++)
	{
		$analysis[$airlines[$i]] = array(0, 0, 0, 0);
	}
	
	for($i = 0;$i < sizeof($tweet_table);)
	{
		$pos = 0;
		$neu = 0;
		$neg = 0;
		if(isset($tweet_table[$i][1]) && $tweet_table[$i][1] == -1)
		{
			$neg = $tweet_table[$i][2];
			$i++;
		}
		else
		{
			$neg = 0;
		}
		if(isset($tweet_table[$i][1]) && $tweet_table[$i][1] == 0)
		{
			$neu = $tweet_table[$i][2];
			$i++;
		}
		else
		{
			$neu = 0;
		}
		if(isset($tweet_table[$i][1]) && $tweet_table[$i][1] == 1)
		{
			$pos = $tweet_table[$i][2];
			$i++;
		}
		else
		{
			$pos = 0;
		}
		
		$analysis[$tweet_table[($i-1)][0]] = array($pos, $neu, $neg, $pos+$neu+$neg);
	}
ksort($analysis);
arsort($analysis);
 
    
    
?>
          <!-- Breadcrumb-->
          <div class="breadcrumb-holder container-fluid">
            <ul class="breadcrumb">
              <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
              <li class="breadcrumb-item active">Analysis</li>
            </ul>
          </div>
          <section class="tables">   
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Process Analysis Info</h3>
                    </div>
                    <div class="card-body">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>No.</th>
                            <th>Airlines Companies</th>
                            <th>Number Of Positive</th>
                            <th>Number Of Natural</th>
                            <th>Number Of Negative</th>
                            <th>Total Number Of Tweets</th>
                         
                          </tr>
                        </thead>
                          
                        <tbody>

                            <?php $i=1; foreach($analysis as $k=>$airline){?>
                            <tr>
                            <th scope="row"><?php echo $i++;?>.</th>
                            <td><?php echo explode('_',$k)[0];?></td>
                            <td><?php echo $airline[0];?></td>
                            <td><?php echo $airline[1];?></td>
                            <td><?php echo $airline[2];?></td>
                            <td><?php echo $airline[3];?></td>
							</tr>
							<?php }?>
                     </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
<!--
          <section class="forms"> 
            <div class="container-fluid">
              <div class="row">
                  <div class="col-lg-12">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      
                        <div class="line"></div>
                        <div class="form-group row">
                          
                         
                            
                        </div>
                        <div class="line"></div>
                        
                      </form>          
                    </div>
                  </div>
                </div>
            </div>
           </div>
          </section>
-->
          
          <!-- Page Footer-->        
  <?php include("footer.php") ?>
<!-- Javascript files-->
    <script src="Newbook.js"></script>   <!-- new book validation-->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="vendor/popper.js/umd/popper.min.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="vendor/jquery-validation/jquery.validate.min.js"></script>
    <script src="js/front.js"></script>
  </body>
</html>