<?php
function createTest(){
	$t = '我就测试一下怎么了？';
	echo $t;
}
function ssq_creat($red_max,$blue_max,$n,$r=6,$b=1){
	$red = $blue = [];
	for ($i=1;$i<($red_max+1);$i++){
		$red[] = sprintf('%02s', $i);
		if($i<($blue_max+1)){
			$blue[] = sprintf('%02s', $i);
		}
	}
	$red=array_flip($red);
	$blue=array_flip($blue);
	$t = '';
	for ($a=1;$a<=$n;$a++){
		$rarr = array_rand($red,$r);
		$num = sprintf('%02s', $a);
		$t.=implode("  ", $rarr);
		if($blue_max > 0 && $b>0){
			$barr = array_rand($blue,$b);
			if(!is_array($barr)){
				$barr = [$barr];
			}
			$t .=  '  +  ' . implode("  ", $barr);
		}
		$t .= PHP_EOL;
	}
	return $t;
}
if(count($_POST)>0){
	echo ssq_creat($_POST['red_max'],$_POST['blue_max'],$_POST['times'],$_POST['red'],$_POST['blue']);
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>彩票随机生成器</title>
	<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
	<style type="text/css">
		input[type="submit"]{margin: 50px 0;}
		div{border:1px solid #ddd;padding: 5px 10px;margin-bottom: 10px;}
		div>p{padding: 2px 5px;}
		div>p:first-child{border-bottom:1px solid #ddd;}
		div>p:last-child{font-size: 14px;color: #848484;/*border:1px solid #ddd;*/}
		div>p:first-child span{display: inline-block;/* width: 50%;*/}
		div>p:first-child span:first-child{width: 10%;min-width: 200px;border-right:1px solid #ddd;margin-right: 10px;}
		div>p:last-child span{width: 50%;}
		div>p span:last-child input{width: 100%;}
		div>p span:last-child select{width: 80%;min-width: 150px;}
		button[type="button"] { color: #ffffff; font-size: 1.05em; height: 29px; padding: 2px 18px 3px 18px; margin: 0 0.5em 0 0; background: #3a6ea5; border: 1px solid #046190; cursor: pointer; }
	</style>
</head>
<body>
	<div>
		<p>
			<span>红球最大值</span>
			<input type="text" name="red_max" id="red_max" class="red_max" value="33" placeholder="默认为双色球33">
		</p>
		<p>默认为双色球33</p>
	</div>
	<div>
		<p>
			<span>蓝球最大值</span>
			<input type="text" name="blue_max" id="blue_max" class="blue_max" value="16" placeholder="默认为双色球16">
		</p>
		<p>默认为双色球16</p>
	</div>
	<div>
		<p>
			<span>单复式</span>
			<input type="radio" name="how" id="how-0" class="how" value="0" checked="checked"><label for="how-0">单式</label>
			<input type="radio" name="how" id="how-1" class="how" value="1"><label for="how-1">复式</label>
		</p>
		<p>
			单式：6+1<br>
			复式：n+n
		</p>
	</div>
	<div id="show">
		<p>
			<span>(<b style="color:red">仅复式有效</b>)红球个数：</span>
			<span><input type="text" name="red" id="red" class="red" value="6" style="width: 100%" placeholder="请输入大于等于6的数字"></span>
			<span>  蓝球个数：</span>
			<span><input type="text" name="blue" id="blue" class="blue" value="1" style="width: 100%" placeholder="请输入大于等于1的数字"></span>
		</p>
		<p>双色球中红球个数不得小于6，蓝球个数不得小于1</p>
	</div>
	<div>
		<p>
			<span>生成组数</span>
			<span><input type="text" name="times" id="times" class="times" value="1" style="width: 100%" placeholder="请输入大于等于1的数字"></span>
		</p>
		<p></p>
	</div>
	<div>
		<button type="button" onclick="begin()">开始生成</button>
	</div>
	<div class="show">
		<textarea type="text" style="width: 100%;" rows="15"></textarea>
	</div>
	<script>
		function begin(){
			var how = $(".how:checked").val();
			var times = $(".times").val() - 0;
			var red_max = $(".red_max").val() - 0;
			var blue_max = $(".blue_max").val() - 0;
			var red = $(".red").val() - 0;
			var blue = $(".blue").val() - 0;
			if(red_max < red){
				alert('红球最大值必须大于等于红球个数');
				return false;
			}
			if(blue_max < blue){
				alert('蓝球最大值必须大于等于蓝球个数');
				return false;
			}
			$.ajax({
				type: 'post',
				url: "",
				data: {red_max,blue_max,how,red,blue,times},
				success: function(e) {
					$(".show textarea").val(e);
				},
				error: function(s) {
					alert("提交错误");
					$(".show textarea").val('提交失败，当前返回状态：' + s.status + "\r\n当前返回内容："+ s.responseText +"\r\n请根据实际情况处理\r\n");
					console.log(s)
				}
			});
		}
	</script>
</body>
</html>
