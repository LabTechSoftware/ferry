<?php namespace Labtech\Ferry;

use Illuminate\Support\ServiceProvider;

class FerryServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		App::singleton('ferryCurlConnection', function()
		{
		    return new Curl\CurlConnection;
		});

		App::singleton('ferryCurlResult', function()
		{
		    return new Curl\CurlResult;
		});

		App::singleton('ferrySoapConnection', function()
		{
		    return new Soap\SoapConnection;
		});

		App::singleton('ferrySoapResult', function()
		{
		    return new Soap\SoapResult;
		});

		App::singleton('ferryConfig', function()
		{
		    return new Config;
		});

		App::singleton('ferryCreds', function()
		{
		    return new Creds;
		});

		App::singleton('ferryRequestParams', function()
		{
		    return new RequestParams;
		});

		App::singleton('ferryResource', function()
		{
		    return new Resource;
		});

		App::singleton('ferryResult', function()
		{
		    return new Result;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}