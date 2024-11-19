<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\App;
use App\Libraries\Envapi;

class LoginFilter implements FilterInterface
{
	/**
	 * Verifies that a user is logged in, or redirects to login.
	 *
	 * @param RequestInterface $request
	 * @param array|null $params
	 *
	 * @return mixed
	 */
	public function before(RequestInterface $request, $params = null)
	{
		if (! function_exists('logged_in'))
		{
			helper('auth');
		}

		$current = (string)current_url(true)
			->setHost('')
			->setScheme('')
			->stripQuery('token');

		$config = config(App::class);
		if($config->forceGlobalSecureRequests)
		{
			# Remove "https:/"
			$current = substr($current, 7);
		}

		// Make sure this isn't already a login route
		if (in_array((string)$current, [route_to('login'), route_to('forgot'), route_to('reset-password'), route_to('register'), route_to('activate-account')]))
		{
			return;
		}

		// if no user is logged in then send to the login form
		$authenticate = service('authentication');
		if (! $authenticate->check())
		{
			session()->set('redirect_url', current_url());
			return redirect('login');
		}
		$request = \Config\Services::request();
	    $uri = $request->getUri();
	    $path = $uri->getPath();
	    $group = $request->getGet('group');
		$verified = Envapi::validatePurchase("idea_feedback");
		if (!$verified && $path != "admin/logout" && $path != "admin/settings/save" &&($path != "admin/settings" || ($path == "admin/settings" && $group != "purchase-code"))) {			
			if(in_groups(['admin','employee'])){
				set_alert('danger',app_lang('error'),app_lang('reactivate_purchase_key_admin'));
				return redirect()->to(base_url('index.php/admin/settings?group=purchase-code'));
			} else {
				set_alert('danger',app_lang('error'),app_lang('reactivate_purchase_key_client'));
				return redirect()->to(base_url('index.php/admin/logout'));
			}
		}
	}

	/**
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param array|null $arguments
	 *
	 * @return void
	 */
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
	}
}
