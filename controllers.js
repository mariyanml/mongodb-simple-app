var MongoApp = angular.module('mongo', ['ui.bootstrap']);

/**
 * Constructor
 */
function MongoController() {}

MongoController.prototype.onMongo = function() {
	var value = this.scope_.msg
	this.scope_.msg = "";
	this.http_.get("guestbook.php?cmd=set&key=messages&value=" + value).success(angular.bind(this, function(data) {
		this.scope_.mongoResponse = "Updated.";
		this.getMessages();
	}));
};

MongoController.prototype.getMessages = function() {

	this.http_.get("guestbook.php?cmd=get").success(angular.bind(this, function(data) {
		this.scope_.messages = data;
	}));
};

MongoApp.controller('MongoCtrl', function ($scope, $http, $location) {
        $scope.controller = new MongoController();
        $scope.controller.scope_ = $scope;
        $scope.controller.location_ = $location;
        $scope.controller.http_ = $http;
        $scope.messages = [];

	$scope.controller.getMessages();
});
