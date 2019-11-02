<html>
<head>
	<meta charset="utf-8">
	<title>下拉选择框与输入框联动，直接添加选中值到输入框</title>
</head>
<body>
<select id="uiSel">
	<option value="-1">请选择</option>
	<option value="until1">unti1</option>
	<option value="until2">unti2</option>
	<option value="until3">unti3</option>
	<option value="until4">unti4</option>
	<option value="until5">unti5</option>
</select>
<input type="checkbox" name="" id="show" />

</body>
<script type="text/javascript">
	document.getElementById('uiSel').onchange=function (){
		if(this.options[0].value==-1)this.options[0]=null;
		document.getElementById('show').value=this.value
	};
</script>
</html>