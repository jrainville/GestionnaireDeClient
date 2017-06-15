$(function () {
	$('#cout').blur(function () {
		var coutField = this;
		coutField.value = coutField.value.replace(',', '.');
		var coutValue = parseFloat(coutField.value).toFixed(2);
		if (coutValue >= 0) {
			var tps = ((coutValue * 5) / 100).toFixed(2);
			var tvq = (coutValue * 0.09975).toFixed(2);
			$('#TPS')[0].value = tps;
			$('#TVQ')[0].value = tvq;
			$('#total')[0].value = (parseFloat(coutValue) + parseFloat(tps) + parseFloat(tvq)).toFixed(2);
		}
	});
});