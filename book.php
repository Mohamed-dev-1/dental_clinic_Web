 <?php
 // check if form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $fullname = $_POST["fullname"];
    $phone_number = $_POST["phonenumber"];
    $service = $_POST["service"];      
    $date = $_POST["bookdate"];
}
        



//Display data after submission

if($_SERVER["REQUEST_METHOD"] == "POST")
                                            {
                                                echo "<h2> Booking Info : </h2>";
                                                echo "Patient : $fullname <br>";
                                                echo "Phone number : $phone_number <br>";
                                                echo "Booking date : $date <br>" ;
                                                echo "Service : $service <br>"; 
                                            }
                                        ?>