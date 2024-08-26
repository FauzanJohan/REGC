<form action ="" method="POST">
<label>Enter Author Name:</label>
<input type="text" name="authorname" placeholder="Enter Author Name" required/>
<br /></br />
<button type="submit" name="submt">Submit</button>
</form>

<?php
if (isset($_POST['authorname']) && $_POST['authorname']!="") {
    $authorname = $_POST['authorname'];
} else {
    $authorname = 'unknown';
}

//https://api.nytimes.com/svc/books/v3/reviews.json?author=Stephen+King&api-key=G1LIDdRsH7Vqxxnw6ApngeAWC5qjXhGj
$url = "https://api.nytimes.com/svc/books/v3/reviews.json?author=".$authorname."&api-key=G1LIDdRsH7Vqxxnw6ApngeAWC5qjXhGj";

//echo $url . "<br>";

$client = curl_init($url);

curl_setopt($client, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($client);

$result = json_decode($response, TRUE);

echo "result:".$result["status"]."<br>";
echo "Num of results: ".$result["num_results"]."<br>";

foreach ($result["results"] as $key => $value){

    echo "URL: ".$key.": ".$result["results"]["{$key}"]["url"]."<br>";
    echo "Publication Date: ".$key.": ".$result["results"]["{$key}"]["publication_dt"]."<br>";

}

//var_dump($result);
