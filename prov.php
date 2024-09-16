<style>
#showmore-triger {
	text-align: center;
	padding: 10px;
	background: #ffdfdf;
}
 
/* Вывод товаров */
.prod-list {
	overflow: hidden;
	margin: 0 0 20px 0;
}
.prod-item {
	width: 174px;
	height: 230px;
	float: left;
	border: 1px solid #ddd;
	padding: 20px;
	margin: 0 20px 20px 0;
	text-align: center;
	border-radius: 6px;
}
.prod-item-img {
	width: 100%;
}
.prod-item-name {
	font-size: 13px;
	line-height: 16px;
}
 
.prod-list .prod-item:nth-child(3n) {
	margin-right: 0
}
</style>

<?php
// Кол-во элементов
$limit = 12; 
 
// Подключение к БД
$dbh = new PDO('mysql:dbname=db_name;host=localhost', 'логин', 'пароль');
 
// Получение записей для первой страницы
$sth = $dbh->prepare("SELECT * FROM `prods` LIMIT {$limit}");
$sth->execute();	
$items = $sth->fetchAll(PDO::FETCH_ASSOC);	
 
// Кол-во страниц 
$sth = $dbh->prepare("SELECT COUNT(`id`) FROM `prods`");
$sth->execute();
$total = $sth->fetch(PDO::FETCH_COLUMN);
$amt = ceil($total / $limit);
?>
	
<div id="showmore-list">
	<div class="prod-list">
		<?php foreach ($items as $row): ?>
		<div class="prod-item">
			<div class="prod-item-img">
				<img src="/images/<?php echo $row['img']; ?>" alt="">	
			</div>
			<div class="prod-item-name">
				<?php echo $row['name']; ?>		
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</div>
 
<div id="showmore-triger" data-page="1" data-max="<?php echo $amt; ?>">
	<img src="ajax-loader.gif" alt="">
</div>

<script src="/jquery/2.1.1/jquery.min.js"></script>
 
 <script>
 var block_show = false;
  
 function scrollMore(){
     var $target = $('#showmore-triger');
     
     if (block_show) {
         return false;
     }
  
     var wt = $(window).scrollTop();
     var wh = $(window).height();
     var et = $target.offset().top;
     var eh = $target.outerHeight();
     var dh = $(document).height();   
  
     if (wt + wh >= et || wh + wt == dh || eh + et < wh){
         var page = $target.attr('data-page');	
         page++;
         block_show = true;
  
         $.ajax({ 
             url: '/ajax.php?page=' + page,  
             dataType: 'html',
             success: function(data){
                 $('#showmore-list .prod-list').append(data);
                 block_show = false;
             }
         });
  
         $target.attr('data-page', page);
         if (page ==  $target.attr('data-max')) {
             $target.remove();
         }
     }
 }
  
 $(window).scroll(function(){
     scrollMore();
 });
     
 $(document).ready(function(){ 
     scrollMore();
 });
 </script>