g = {
	ifCheck: function (data){
	    return data != 0 || data != null || data != '';
	},
	ifZero: function (data){
	    return data == 0;
	},
	getAge: function (data){
	    return new Date().getFullYear() - new Date(data).getFullYear(); // date diff returns num
	},
	getPeriod: function (data,a,m){
	    return new Date(data).getFullYear().toString() +'(Age : '+a+')'+ m;
	},
	getYear: function (data){
	    return new Date(data).getFullYear();
	}
}

c = {
	chartData: function (values){
	    var data=[],dataArray=[];
	    data.values= values;
	    data.rem = 100 - data.values;
	    dataArray.push(data);
	    return dataArray;
	}
}