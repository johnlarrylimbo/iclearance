var functionalfoodsApp = angular.module("functionalfoodsApp", ['ngRoute', 'angularUtils.directives.dirPagination']);
var url = "";

if(window.location.port!=""){
	url = window.location.protocol+"//"+ window.location.hostname+":8500/";
}
else{
	url = window.location.protocol+"//"+ window.location.hostname+"/";
}

// if(window.location.pathname.includes("uicbis") || window.location.pathname.includes("UICBIS")){
// 	url = url + "uicbis/index.cfm";
// }
// else{
// 	url = url + "index.cfm";
// }
