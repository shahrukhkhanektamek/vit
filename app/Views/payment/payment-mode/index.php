<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=env('APP_NAME') ?> || Payment</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style>
.card img {
    width: 100%;
}

body, html {
    height: 100%;
    background: lightgray;
}
body {
    display: flex;
    align-items: center;
    text-align: center;
}
.card-inner {
    background: white;
    padding: 10px 10px;
    border-radius: 10px;
}
</style>

</head>
<body>


  


      <?php 
      foreach($payment_setting as $key=>$value)
      {
        $keys = json_decode($value->data);
        $mode = $keys->prefix;
       $prefix = base_url("payment/make-payment");
       ?>
        <div class="col-sm-3 card" style="margin:0 auto;">
          <div class="card-inner">
            <a href="<?=$prefix.'?id='.$id.'&mode='.$mode ?>">
              <img src="<?=base_url('upload/'.@$value->image) ?>">
            </a>
          </div>
        </div>
      <?php } ?>

    


</body>
</html>
