<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});


// Please add your routes to the most appropriate group below. "name" is my own experimentation; may switch that to prefix later
Route::group(array('name'=>'simple'), function(){

	Route::get('/simple/get_all', function()
	{
		$posts = \Post::all();
		return \View::make('simple.get_all')->with('posts', $posts);
	});

	Route::get('/simple/get_one/{id}', function($id)
	{
		$post = \Post::find($id);
		return \View::make('simple.get_one')->with('post', $post);
	});

	Route::get('/simple/has_one_author/{id}', function($id)
	{
		$author = \Post::find($id)->author;
		return \View::make('simple.has_one_author')->with('author', $author);
	});

	Route::get('/simple/get_women/', function()
	{
		$authors = \Author::women()->get();
		return \View::make('simple.get_women')->with('authors', $authors);
	});

	Route::get('/simple/get_by_gender/{gender}', function($gender)
	{
		$authors = \Author::gender($gender)->get();
		return \View::make('simple.get_by_gender')->with('authors', $authors);
	});

	Route::get('/simple/get_author_full/{id}', function($id)
	{
		$author = \Author::find($id);
		return \View::make('simple.get_author_full')->with('author', $author);
	});	

	Route::get('/simple/get_authors_has_posts', function()
	{
		// TODO: all of our authors actually have posts, so you don't see the filter (but this works)
		$authors = \Author::has('posts')->get();
		return \View::make('simple.get_authors_has_posts')->with('authors', $authors);
	});	

	Route::get('/simple/get_authors_has_ten_posts', function()
	{
		$authors = \Author::has('posts', '>=', 10)->get();
		return \View::make('simple.get_authors_has_ten_posts')->with('authors', $authors);
	});	

	Route::get('/simple/get_authors_has_posts_like_open', function()
	{
		// Search for all authors who have a post with "open" in title
		// but does NOT filter to only those posts
		$authors = \Author::whereHas('posts', function($q)
		{
		    $q->where('title', 'like', 'open%');

		})->get();

		return \View::make('simple.get_authors_has_posts_like_open')->with('authors', $authors);
	});	
	// put more routes for simple examples below...

});

Route::group(array('name'=>'intermediate'), function(){

	Route::get('/intermediate/author_many_books/{id}', function($id)
	{
		// This will grab only the books
		$books = \Author::find($id)->books;
		return \View::make('intermediate.author_many_books')->with('books', $books);
	});	

	Route::get('/intermediate/collection_has_key/{author_id}/{book_id}', function($author_id, $book_id)
	{
		// This will grab only the books as a collection, then check for the book_id
		$books = \Author::find($author_id)->books;

		$found = 'Book not found';
		if ($books->contains($book_id))
		{
		    $found = 'Book found';
		}

		return \View::make('intermediate.collection_has_key')->with('found', $found);
	});	

	Route::get('/intermediate/collection_iterator/{author_id}', function($author_id)
	{
		// This will grab only the books as a collection
		$books = \Author::find($author_id)->books->each(function($book)
		{
		    $book->random = rand(0,10);
		});


		return \View::make('intermediate.collection_iterator')->with('books', $books);
	});	


	Route::get('/intermediate/collection_filter/{author_id}', function($author_id)
	{
		// This will grab only the books as a collection
		$books = \Author::find($author_id)->books->filter(function($book)
		{
			//array_filter is applied, and only "true" conditions returned back to collection
		    $book->random = rand(0,1);
		    return $book->random;
		});


		return \View::make('intermediate.collection_filter')->with('books', $books);
	});	

	// This would normally be done in an PUT or POST, but for symplicity..
	Route::get('/intermediate/author_books_sync/{id}', function($id)
	{
		$author = \Author::find($id);

		$books_authored = array(1,4,12);
		$author->books()->sync($books_authored);

		// now you can play with this a bit, adding & removing books like this:
		//$author->books()->attach(8); 

		//$author->books()->detach(1); 		
		
		return \View::make('intermediate.author_books_sync')->with('author', $author);
	});	

	Route::get('/intermediate/author_lastname_accessor', function()
	{
		$authors = \Author::all();
		return \View::make('intermediate.author_lastname_accessor')->with('authors', $authors);
	});	

	Route::get('/intermediate/has_many_posts_through_author/{country}', function($country)
	{
		$country = \Country::where('country', '=', $country)->first();
		return \View::make('intermediate.has_many_posts_through_author')->with('country', $country);
	});	

	Route::get('/intermediate/append_attribute_to_author/{id}', function($id)
	{
		$author = \Author::find($id);

		// not a column - appended field on model. For this example, I'll use an Accessor (getFullNameAttribute)
		// on the model to shape it
		// (TODO: come up with a better use case)
		$author->full_name = $author;

		return \View::make('intermediate.append_attribute_to_author')->with('author', $author);
	});


});

Route::group(array('name'=>'advanced'), function(){

});