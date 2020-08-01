<html>
 <head>
 
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css"/>
		<script src="https://code.jquery.com/jquery-3.3.1.js"/></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>        
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"/></script>
        <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"/></script>      
 </head>
 <body>
  
  <div class="container">
   <div class="panel-group Principal" style="margin-top: 16px;">
    <div class="panel panel-primary">
	 <div class="panel-heading">Filmes Populares</div>
	 <div class="panel-body">
	 <?php 
	  $contador = 0;
	  $texto    = '';
	  $url = 'https://api.themoviedb.org/3/genre/movie/list?api_key=4ec327e462149c3710d63be84b81cf4f&language=en-US';
	  $ch = curl_init( $url );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt( $ch, CURLOPT_MAXREDIRS, 10);
      curl_setopt( $ch, CURLOPT_TIMEOUT, 30);
      curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      // curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; Charset: UTF8','Authorization: Basic '.base64_encode('adlux:PRD4dlux@wi')));
      
      $result = curl_exec($ch);
      $err    = curl_error($ch);
      
      curl_close($ch);
      
      if($err) {
       $log .= '<p>cURL Erro #:'.$err.'</p>';
       $log .= '<p>URL de acesso: '.$url.'</p>';
      } else {
	   // i tried convert to json_decode function but doesnt work...
	   // lets go hard mode then...
	   
	   $bomb = explode('[',$result);
	   // echo 'Registros: '.count($bomb).' <pre>'.$bomb[1].'</pre>';
	   $bomb = explode('{',$bomb[1]);
	   for($i = 0; $i < count($bomb); $i++) {
	    // echo 'Registros: '.count($bomb).' <pre>'.$bomb[$i].'</pre>';
		$cake = explode('"',$bomb[$i]);
        for($j = 0;$j < count($cake);$j++) {
		 // echo '<p>Cake['.$j.']='.$cake[$j].'</p>';
		 if($j == 2) {
		  $Genero[str_replace(':','',str_replace(',','',$cake[$j]))] = trim($cake[5]);	 
		  // echo '<p>'.	 .'==='.$cake[5].'</p>';		  
		 }
		}
//die();		 
	   }
	   
	   $saida  = '<div class="row">';
	   $saida .= '<div class="col-lg-4">Gênero</div>';
	   $saida .= '<div class="col-lg-8">';
	   $saida .= '<select class="form-control" name="Genero" id="Genero" style="height: 32px;">'.PHP_EOL;
	   $saida .= '<option value="Todos">All</option>'.PHP_EOL;		
	   foreach($Genero as $item) {
	    $saida .= '<option value="'.$item.'">'.$item.'</option>'.PHP_EOL;		
	   }
	   $saida .= '</select>'.PHP_EOL;
	   $saida .= '</div>';
	   $saida .= '</div>';
	   echo $saida;
	  }
	  
	  $url = 'https://api.themoviedb.org/3/trending/all/day?api_key=4ec327e462149c3710d63be84b81cf4f';
   
      $ch = curl_init( $url );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "GET");
      curl_setopt( $ch, CURLOPT_MAXREDIRS, 10);
      curl_setopt( $ch, CURLOPT_TIMEOUT, 30);
      curl_setopt( $ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      // curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json; Charset: UTF8','Authorization: Basic '.base64_encode('adlux:PRD4dlux@wi')));
      
      $result = curl_exec($ch);
      $err    = curl_error($ch);
      
      curl_close($ch);
      
      if($err) {
       $log .= '<p>cURL Erro #:'.$err.'</p>';
       $log .= '<p>URL de acesso: '.$url.'</p>';
      } else {
	   
       // echo '<pre>'.$result.'</pre>';	   
		  
       // $result = json_decode($result,true);
	   $saida  = '<div class="row" style="margin-top: 32px;">'.PHP_EOL;
       $saida .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">'.PHP_EOL;
          
	   $saida .= '<table class="table responsive odd bordered" id="datatable" style="width: 100%">'.PHP_EOL;
	   $saida .= '<thead>'.PHP_EOL;
	   $saida .= '<tr style="background-color: #4682b4; color: #fff;">';
	   $saida .= '<th>Name</th>';
	   $saida .= '<th>Poster</th>';
	   $saida .= '<th>Overview</th>';
	   $saida .= '<th>Release Date</th>';
	   $saida .= '<th>Genre(s)</th>';
	   $saida .= '</tr>'.PHP_EOL;
	   $saida .= '<thead>'.PHP_EOL;
	   $saida .= '<tbody>'.PHP_EOL;
	   
	   // as vezes as coisas vem facil, as vezes nao entao vamos explodir tudo
	   // whats happened here? simple, text under " dont follow a standard communication settings, this make communication bettween technologies doesnt work as well.
	   // please report your partner to correct this problem, its better.
	   //foreach($result as $item) {
	    //echo $item->original_title;
	   // }
	   
	   $bomba = explode('{',$result);
	   for($i = 2; $i < count($bomba); $i++) {
	    // echo '<br><br> POS['.$i.']='.$bomba[$i].' | ';
		//
		$cake = explode('"',$bomba[$i]);
		for($j = 0; $j < count($cake); $j++) {
		 // echo '<br><br>Pedaco['.$j.']='.$cake[$j].' | ';
		 if(trim($cake[$j]) == 'original_title') {
		  $c1 = $cake[($j + 2)];
		 }
		 if(trim($cake[$j]) == 'poster_path') {
		  $c2 = 'https://image.tmdb.org/t/p/w220_and_h330_face'.$cake[($j + 2)];
		 }
		 if(trim($cake[$j]) == 'overview') {
		  $c3 = $cake[($j + 2)];
		 }
		 if(trim($cake[$j]) == 'release_date') {
		  $c4 = $cake[($j + 2)];
		 }
		 
		 $generos = 'All';
		 if(trim($cake[$j]) == 'genre_ids') {
		  $c5 = explode('[',$cake[($j + 1)]);
		  $c5 = explode(']',$c5[0]);
		  if(count($c5) > 2) {
		   $c5 = explode(',',$c5[0]);
           for($k = 0; $k < count($c5); $k++) {
			echo '<p>C5['.$k.']='.$c5[$k].'</p>';
            $generos .= $Genero[($c5[$k])];
			if($k < count($c5)) {
			 $generos .= ' ';
			}
		   }			   
		  } else {
		   $c5 = $cake[0];
		   $generos .= $c5;
		  }
		 }
		 
		 if(isset($c1) && isset($c2) && isset($c3) && isset($c4)) {
		  // nome, poster, overview, release date e genero
		  $contador++;
		  $saida .= '<tr class="'.$generos.'">';
		  $saida .= '<td><a href="javascript:void(0);" onclick="Display(\''.$contador.'\');" style="text-decoration: none;">'.$c1.'</a></td>';
		  $saida .= '<td><a href="javascript:void(0);" onclick="Display(\''.$contador.'\');" style="text-decoration: none;"><img src="'.$c2.'" class="img_responsive"></a></td>';
		  $saida .= '<td><a href="javascript:void(0);" onclick="Display(\''.$contador.'\');" style="text-decoration: none;">'.$c3.'</a></td>';
		  $saida .= '<td><a href="javascript:void(0);" onclick="Display(\''.$contador.'\');" style="text-decoration: none;">'.$c4.'</a></td>';
		  $saida .= '<td>'.$generos.'</td>';
		  $saida .= '</tr>'.PHP_EOL;
		  
		  $texto .= '<div class="row ShowItem ShowItem'.$contador.'" style="display:none; margin-top: 16px">';
          $texto .= ' <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">';
	      $texto .= '  <img src="'.$c2.'" class="img_responsive" style="width: 100%">';
	      $texto .= ' </div>';
	      $texto .= ' <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">';
	      $texto .= '  <h1 style="font-size: 14px; color: #000; font-family: Verdana;">'.$c4.' - '.$c1.'</h1>';
	      $texto .= '  <p style="font-size: 12px; color: #000; font-family: Verdana; font-style: italic; margin-top: 6px;">'.$c5.'</p>';
	      $texto .= '  <p style="font-size: 10px; color: #000; font-family: Verdana; font-style: normal; margin-top: 6px;">'.$c3.'</p>';
	      $texto .= '  <p align="right" style="margin-top: 24px; margin-bottom: 32px;"><a href="javascript:void(0);" onclick="HideDisplay();" class="btn btn-warning">Return</a></p>';
	      $texto .= ' </div>';
          $texto .= '</div>'.PHP_EOL;
		  
		  unset($c1,$c2,$c3,$c4);
		 }
		 
		}
		
		
	   }
	   	   
	   $saida .= '</tbody>'.PHP_EOL;
	   $saida .= '</table>'.PHP_EOL;
	   $saida .= '</div>'.PHP_EOL;
	   $saida .= '</div>'.PHP_EOL;
	   echo $saida;
	  }
	 ?>
	 </div>
	</div>
   </div>
   <?php 
    if(isset($texto)) {
	 echo $texto;
	}
   ?>
  </div>
 </body>
 <script type="text/javascript">
  $(document).ready(function() {
    $('#datatable').DataTable();
	
	
	$("#Genero").change(function() {
	 $(".All").hide();
	 $("."+$("#Genero").val()+"").show();
	});
	
  });
  
  function HideDisplay() {
   $(".ShowItem").hide(300);
   $(".Principal").show(600);
  }
  
  function Display(c1) {
   $(".Principal").hide(300);
   $(".ShowItem"+c1+"").show(600);   
  }
  
 </script>
</html>