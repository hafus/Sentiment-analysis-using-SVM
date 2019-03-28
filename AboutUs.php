<?php
$page="AboutUs";
if(isset($_POST))
{
	foreach($_POST as $airline)
	{
		echo $airline." ";
	}
}
include("header.php");

include("db.php");?>
          <!-- Dashboard Counts Section-->
          
          <!-- Dashboard Header Section    -->
          <section class="dashboard-header"style="padding-top: 20px;padding-bottom: 50px;";>
            <div class="container-fluid">
              <div class="row">
   <section id="cta-2" class="section-padding" style="padding-top: 20px;padding-bottom:px;width: 1100px;height:300px;margin-bottom:15px;">
    <div class="container">
      <div class=" row">
        <div class="col-md-2"></div>
        <div style="background-color:rgb(50, 92, 106);background-color:black;width: 1070px;height: 250px;padding-left: 20px;">
          <br><h2 class="section-title white lg-line"style="color:white">« A few words<br> about our system »</h2>
          <p style="color:white;width: 1000px;margin-top: 16px;">We can use the  social  data  to  analysis  the sentiments  of  airline  passengers  traveling  from/to  Saudi  Arabia.  Twitter  is  one  of  the most popular social media and the twitter posts of passengers can be used as the data set. Using twitter post our system can analyze the satisfaction of passengers towards the airline with  which  they  have  travelled.  The  system  will  be  performing  sentiment  analysis (Positive,  Negative  and  Neutral) and generate  a  statistical  report  for  10 airlines  operating  in GCC. </p>
        </div>
    
      </div>
    </div>
  </section>
  <!--/ contact-->
  <!--footer-->
  <footer id="footer">
    <div class="top-footer">
      <div class="container">
        <div class="row"   style="background-color:	rgb(50, 92, 106);color:white;">
          <div class="col-md-4 col-sm-4 marb20"> <br>
            <div class="ftr-tle">
              <h4 class="white no-padding">About Us</h4>
            </div>
            <div class="info-sec"> <br>
              <p>We are students of the Department of Computer Science. We tried to design a program that analyzes tweets and people's  in twitter, opinions about the top ten flights operating within the Kingdom.</p>
            </div>
          </div>
          <div class="col-md-4 col-sm-4 marb20">
            <div class="ftr-tle"> <br>
              <h4 class="white no-padding">Quick Links</h4>
            </div>
            <div class="info-sec" style=" padding-left: 30px;"> <br>
              <ul class="quick-info">
                <li><a href="index.php" style="color:white;">Home</a></li>
                <li><a href="dashboard.php" style="color:white;">Dashboard</a></li>
                <li><a href="loan.php" style="color:white;">Anlysis</a></li>
                <li><a href="AboutUs.php" style="color:white;">About us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4 col-sm-4 marb20"> <br>
            <div class="ftr-tle">
              <h4 class="white no-padding">Follow us</h4>
             
            </div>
            <div class="" style="padding-left: 30px;padding-top:10px"> 
              <ul class="">
                <li class="" style="margin-bottom: 7px;"><a href="https://www.facebook.com/" ><img src="img/face.png"width="40"height="35" style="background-color:white;"></a></li>
                 
                  <li class="" style="margin-bottom: 7px;"><a href="https://myaccount.google.com/" ><img src="img/Google.jpg" width="40"height="35" style="background-color:white;"></a></li>
                  
                  <li class="" style="margin-bottom: 7px;"><a href="https://www.linkedin.com/"><img src="img/linkedin-512.png"width="40"height="35"  style="background-color:white;"></a> </li>
                  
                <li class="" style="margin-bottom: 7px;"><a href="https://twitter.com/login" ><img src="img/download.jpg"width="40"height="35" style="background-color:white; "></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-line">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <div class="credits">

            </div>
          </div>
        </div>
        </div>
            </div>
                  </footer>
                </div>
              </div>
          </section>
          <!-- Feeds Section-->
         
          <?php
			include("footer.php");
			?>