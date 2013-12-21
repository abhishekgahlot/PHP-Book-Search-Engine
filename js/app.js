document.getElementById('submit').onclick = function() {
	getData();
};
$("input").keypress(function(event) {
	if (event.which == 13) {
		event.preventDefault();
		getData();
	}
});
//if ajax url exist load results
if (window.location.hash !== '') {
	var url = window.location.hash.substr(1);
	$('#search').val(decodeURIComponent(url));
	$.post('engine/api.php', {
		q: url,
		p: 1
	}, function(data) {
		$('#books-well').empty();
		$('#books-well').html(data);
		$('.loader').hide();
		$('#sort,.pagination').show();
		if (data.match("Error :")) {
			$('#sort,.pagination').hide();
		}
	});
}

function getData(page) {
	if (typeof(page) === 'undefined') page = 1;
	var searchVal = document.getElementById('search').value;
	$('.loader').css({
		"display": "block",
		"margin-bottom": "40px"
	});
	$.post('engine/api.php', {
		q: searchVal,
		p: page
	}, function(data) {
		$('#books-well').empty();
		$('#books-well').html(data);
		$('.loader').hide();
		$('#sort,.pagination').show();
		window.location.hash = searchVal;
		if (data.match("Error :")) {
			$('#sort,.pagination').hide();
		}
	});
}
//Buy function

function buy(id) {
	$('.loader').css({
		"display": "block",
		"margin-bottom": "40px"
	});
	var newWindow = window.open();
	$.post('engine/api.php', {
		isbn: id
	}, function(data) {
		if (data != 'Book Not Found') {
			newWindow.location = data;
		} else {
			alert(data);
		}
		$('.loader').hide();
		window.location.hash = $('#search').val();
	});
}
//Sort Button Handler
document.getElementById('sort').onclick = function() {
	$('.loader').css({
		"display": "block",
		"margin-bottom": "40px"
	});
	var page = $('.paginate li.active').attr('id');
	var searchVal = document.getElementById('search').value;
	$.post('engine/api.php', {
		q: searchVal,
		p: page,
		sort: true
	}, function(data) {
		$('#books-well').empty();
		$('#books-well').html(data);
		$('.loader,#sort').hide();
		$('.pagination').show();
	});
};
//Pagination handler
$(".pagination li").click(function() {
	var page = this.id;
	getData(page);
	$(".pagination li").removeClass("active");
	$(this).addClass("active");
});

//Preview Function
function preview(isbn) {
	initialize(isbn);
	$('#previewModal').modal('show');
	$('#previewModal').on('hide', function() {
		window.location.hash = $('#search').val();
	});
}
//Google book api preview
google.load("books", "0");

function initialize(isbn) {
	var viewer = new google.books.DefaultViewer(document.getElementById('previewBody'));
	viewer.load('ISBN:' + isbn, alertNotFound);
}

function alertNotFound() {
	$('#previewModal').modal('hide');
	alert("Book Preview Not Available!");
}