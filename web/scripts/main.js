(function() {
	var app = angular.module("trtApp", []);

	app.config(function($interpolateProvider){
		$interpolateProvider.startSymbol('[[').endSymbol(']]');
	});

	app.controller('trtCtrl', function($scope, $http) {
		$scope.apiKey = localStorage.getItem('apiKey') || '';
		$scope.secret = localStorage.getItem('secret') ||  '';
		$scope.fundIds = localStorage.getItem('fundIds') || 'BTCEUR,ETHEUR';
		$scope.loading = false;

		$scope.showBalance = function() {
			$scope.loading = true;

			$http
				.get('/balance/' + $scope.apiKey + '/' + $scope.secret + '/' + $scope.fundIds)
				.then(function(response) {
					localStorage.setItem('apiKey', $scope.apiKey);
					localStorage.setItem('secret', $scope.secret);
					localStorage.setItem('fundIds', $scope.fundIds);

					$scope.err = null;
					$scope.response = response;
					$scope.loading = false;
				}, function err(response) {
					$scope.err = {
						statusCode: response.status,
						data: response.data
					};
					$scope.loading = false;
				});
		};

		if ($scope.apiKey && $scope.secret && $scope.fundIds) {
			$scope.showBalance();
		}
	});
}());
