<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<style>
	body{
		background-color: #fff;
		height: 500px;
		line-height: 500px;
	}
	form{
		width: 960px;
		margin: 0 auto;
	}
	input{
		width: 70%;
		margin-left: 10%;
		height: 30px;
	}
	input:focus{
		outline: none;
	}
	button{
		display: inline-block;
		width: 10%;
		height: 35px;
		background-color: #3385ff;
		border: none;
		border-radius: 5px;
		color: #eee;
	}
    button:focus{
        outline: none;
    }
</style>
<body>
    <input type="text" id="text">
    <button id="submit">录入ISBN</button>

    <script src="../JS/jquery.min.js"></script>
    <script>
        $("#submit").click(function () {
            var text = $("#text").val();
            $.ajax({
                url:'LocalBookMu.php',
                type:'POST',
                dataType:"TEXT",
                data:{ISBN:text},
                success:function () {
                    alert("录入成功");
                }
            });
        });
    </script>

</body>
</html>