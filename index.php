<?php
$page="Home";
include("header.php");

include("db.php");?>
          <!-- Dashboard Counts Section-->
          
          <!-- Dashboard Header Section    -->
          <section class="dashboard-header"style="padding-top: 20px";>
            <div class="container-fluid">
              <div class="row">
                <!-- Statistics  ""-->
                <div class="statistics col-lg-3 col-12" style="margin-right: ;" >
                
                <div class="" style="background-color: white; width:999px; height: 830px;margin-right: 8px;">
                <div style="margin-left:350px;   ">
                  <form style="width:600px; height:500px; margin:0px; padding: none;" onsubmit="return noo()" method="post">
                    <h1 style="margin-left:125px; 110px;height: 30px;padding-top:10px"><strong><em>Airlines</em></strong></h1>
                     <P style="color:#EC7063;margin-left: 80px;color:red;width: 220px;font-size: 9px;margin-bottom: 10px;margin-top: 10px;"><strong>*To better result, please select more airlines</strong></P>
                    <table id="chb" style="width:350px; height:50px; background-color:#F4F6F6 ;" cellpadding="10px">
                        
                        <tbody><tr style="text-align: center;">
                            <th style=" padding-right: 0px;padding-left: 30px; width: 70px;">
                             <input type="checkbox" class="airline" value="0" name="Singapore" onclick="return validate_selections()">
                            </th>
                          
                             <td>
                                <img src="img/air/s11.jpg" width="200 px" height="50px">
                            </td>
                        </tr>
                          <tr  style="text-align: center;">
                           
                            <th style=" padding-right: 0px;padding-left: 30px; width: 70px;">
                               <input type="checkbox" class="airline" name="Japan" onclick="return validate_selections()" value="1">
                            </th>
                          
                             <td>
                                <img src="img/air/9.jpg" width="200 px" height="50px">
                            </td>
                        </tr>
                                      
                             <tr  style="text-align: center;">
                           
                            <th style=" padding-right: 0px;padding-left: 30px; width: 70px;">
                                <input type="checkbox" class="airline" name="Emirates" onclick="return validate_selections()" value="2">
                            </th>
                          
                             <td>
                                <img src="img/air/8.png" width="200 px" height="50px">
                            </td>
                        </tr>
                                      
                             <tr  style="text-align: center;">
                           
                            <th style=" padding-right: 0px;padding-left: 30px; width: 70px;">
                                <input type="checkbox" class="airline" name="Cathay" onclick="return validate_selections()" value="3">
                            </th>
                          
                             <td>
                                <img src="img/air/7.png" width="200 px" height="50px">
                            </td>
                        </tr>
                                      
                                 <tr  style="text-align: center;">
                           
                            <th style=" padding-right: 0px;padding-left: 30px; width: 70px;">
                                <input type="checkbox" class="airline" name="EVA Air" onclick="return validate_selections()" value="4">
                            </th>
                           
                             <td>
                                <img src="img/air/6.jpg" width="200 px" height="50px">
                            </td>
                        </tr>
                                      
                             <tr  style="text-align: center;">
                           
                            <th style=" padding-right: 0px;padding-left: 30px; width: 70px;">
                                <input type="checkbox" class="airline" name="Etihad" onclick="return validate_selections()" value="5">
                            </th>
                            
                             <td>
                                <img src="img/air/5.jpg" width="200 px" height="50px">
                            </td>
                        </tr>                                                                                                                                              
                         <tr  style="text-align: center;">
                           
                            <th style=" padding-right: 0px;padding-left: 30px; width: 70px;">
                              <input type="checkbox" class="airline" name="Lufthansa" onclick="return validate_selections()" value="6">
                            </th>
                             <td>
                                <img src="img/air/4.png" width="200 px" height="50px">
                            </td>
                        </tr>
                                                     
                         <tr  style="text-align: center;">
                           
                            <th style=" padding-right: 0px;padding-left: 30px; width: 70px;">
                              <input type="checkbox" class="airline" name="Oman" value="7" onclick="return validate_selections()">
                            </th>
                          
                             <td>
                                <img src="img/air/oman333.jpg" width="200 px" height="50px">
                            </td>
                        </tr>
                        
                             <tr  style="text-align: center;">
                           
                            <th style=" padding-right: 0px;padding-left: 30px; width: 70px;">
                                <input type="checkbox" class="airline" name="Saudi" onclick="return validate_selections()" value="8">
                            </th>
                           
                             <td>
                                <img src="img/air/2.jpg" width="200 px" height="50px">
                            </td>
                        </tr>
                        
                         <tr  style="text-align: center;">
                           
                            <th style=" padding-right: 0px;padding-left: 30px; width: 70px;">
                                <input type="checkbox" class="airline" name="Royal" onclick="return validate_selections()" value="9">
                            </th>
                           
                             <td>
                                <img src="img/air/1morro.png" width="200 px" height="50px">
                            </td>
                        </tr> 
                                                                             
                    </tbody></table>

                    <div style="margin-top:5px;  ">
                    <input type="submit" id="submitbtn" class="btn btn-primary" disabled="" onclick="load_page()" style="width: 350px; height:40px;" value="Analyze"></div>
                 <div id = 'res'></div>
			</form>
    </div>

                </div>
                <!-- form validation javaScript   -->               
                <script src="js/analysis_btn.js"></script>
              </div>
            </div>
          </section>
          <!-- Feeds Section-->
         
          <?php
			include("footer.php");
			?>
			
			<!-- preloader animation html code-->
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


  </body>
</html>