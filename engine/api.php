<?php

/*Author
Abhishek Gahlot
For any info contact at me@abhishekgahlot.com
This is V 2.2 Update fixing amazon problem
*/

include '../admin/config.php';

class Request

{
	//Note the values are not parsed in array ,as it will be too big for array.

	private $url = 'https://www.googleapis.com/books/v1/volumes?q=';//Default Google Api URL

	private $query = '&fields=totalItems,items(id,saleInfo/retailPrice,volumeInfo/title,volumeInfo/publishedDate,volumeInfo/subtitle,volumeInfo/industryIdentifiers,volumeInfo/authors,volumeInfo/description,volumeInfo/imageLinks,volumeInfo/pageCount)';

	private $sort='&orderBy=newest'; //This is used to sort books by newest

	private $page='&startIndex='; //Used for pagination


	function GetData($query,$page=false,$api_key,$sort=false)
	{

		//Error Handling First
		try
		{

			if($query=='')
			{
				throw new Exception("<h3><center>Error : Please Enter Something</center></h3>");
			}


			if($api_key==''||$api_key=='API_KEY_HERE')
			{
				throw new Exception("<h3><center>Error : Please Read Documentation and Set up API Key In Admin Panel</center></h3>");
			}

			if($page>9)
			{
				throw new Exception("Error : Page is Not Defined");
			}

		}
		catch(Exception $e)
		{
			die($e->getMessage());

		}



		if($sort==true)
		{	$page===false ? $page=1 : $page=$page;

			$url = $this->url . urlencode($query) . '&key=' . $api_key . '&alt=json' . $this->query.$this->page.$page.$this->sort;

		}elseif($page==true)
		{
			$url = $this->url . urlencode($query) . '&key=' . $api_key . '&alt=json' . $this->query.$this->page.$page;
		}else{

			$url = $this->url . urlencode($query) . '&key=' . $api_key . '&alt=json' . $this->query;
		}

		$data = @file_get_contents($url);

		$data === FALSE ? die("<h3><center>Error : Connection Error ! Please try again.</h3></center>") : $data=json_decode($data);


	if (!array_key_exists('items', $data))
		{
    		die("No Results Found!");
    	}


		foreach($data->items as $item)
		{


			//$booktitle = $item->volumeInfo->title;
			$booktitle = (isset($item->volumeInfo->title) ? $item->volumeInfo->title : false);

			//$description = (isset($item->volumeInfo->description) ? $item->volumeInfo->description : false);
			if(!empty($item->volumeInfo->description)){

				$description =implode(' ', array_slice(explode(' ', $item->volumeInfo->description), 0, 130)).'... ';

			}else{

				$description="Description Not Available";
			}


			if(!empty($item->volumeInfo->authors)){


			 $authors = $item->volumeInfo->authors[0];

		     $authors=htmlspecialchars($authors,ENT_QUOTES, 'UTF-8');


			}else{

				$authors=false;
			}



			$image = (isset($item->volumeInfo->imageLinks->thumbnail) ? $item->volumeInfo->imageLinks->thumbnail : false);


			$isbnNum = (isset( $item->volumeInfo->industryIdentifiers) ?  $item->volumeInfo->industryIdentifiers : false);


			$publish_date = (isset($item->volumeInfo->publishedDate) ? $item->volumeInfo->publishedDate : false);


			$pages = (isset( $item->volumeInfo->pageCount) ?  $item->volumeInfo->pageCount : false);


			foreach($isbnNum as $isbn)
			{
				if ($isbn->type == 'ISBN_13')
				{
					$isbnVal= (isset($isbn->identifier) ? $isbn->identifier : false);

				}else if ($isbn->type == 'ISBN_10')
				{
					$isbn10= (isset($isbn->identifier) ? $isbn->identifier : false);
				}
				else{
					$isbnVal=false;
					$isbn10=false;
				}
			}

			//For XSS prevention
			$isbnVal=htmlspecialchars($isbnVal, ENT_QUOTES, 'UTF-8');

			$publish_date=htmlspecialchars($publish_date, ENT_QUOTES, 'UTF-8');


			$pages=htmlspecialchars($pages, ENT_QUOTES, 'UTF-8');

			$booktitle=htmlspecialchars($booktitle, ENT_QUOTES, 'UTF-8');

			$description=htmlspecialchars($description, ENT_QUOTES, 'UTF-8');


			echo '<div class="books well">
					<div class="row-fluid">
						<div class="span3">
							<img src="' . $image . '" />
							  <a href="#" id="buy" onclick="buy('.$isbn10.');" class="btn btn-info">Buy it</a>
							  <a href="#" id="preview" onclick=preview('.$isbnVal.'); class="btn btn-success">Preview</a>
								<ul id="info">
								<li>Author : '.$authors.'</li>
								<li>Release Date: '.$publish_date.'</li>
								<li>ISBN : '.$isbnVal.'</li>
								<li>ISBN-10 : '.$isbn10.'</li>
								<li>Book Pages: '.$pages.'</li>
								</ul>
						</div>
						<div class="span9">
						<h3>' . $booktitle . ' by ' . $authors . '</h3>
							<p>' . $description . '</p>
							</div>
					</div>
				 </div>';

		}

	}

}



//Amazon Class to retrieve Amazon Book Link

class AmazonLink{

	//For 99% Accuracy ISBN 10 is ASIN but not everytime
	function GetAmazonLink($isbn,$amazon_id)
	{
		$url='http://www.amazon.com/dp/'.$isbn.'/?tag='.$amazon_id;
		if(self::x404($url))
		{
			echo $url;

		}else
		{
			echo 'Book Not Found';
		}
	}
	public static function x404($url)
	{
		$handle = curl_init($url);
		curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
		$response = curl_exec($handle);
		$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		if($httpCode == 404) {
		    return false;
		}else
		{
			return true;
		}
		curl_close($handle);

	}
}


//Creating instance of class Request when query is submitted

if(isset($_POST['q'])){

	//Sometime Javascript wont work for default page 1 so setting 1 if its not set
	if($_POST['p']==''||$_POST['p']==1){

		$_POST['p']=false;

	}

	if(!isset($_POST['sort'])){
		$_POST['sort']=false;
	}

	//Creating Class instance in Object

	$object = new Request;

	$object->GetData($_POST['q'],$_POST['p'],$api_key,$_POST['sort']);

}


//Creating instance of class Amazon when buy button is submitted
if(isset($_POST['isbn'])){

	$newLink=new AmazonLink;
	$newLink->GetAmazonLink($_POST['isbn'],$amazon_id);


}