/* eslint-disable no-undef */
/**
 * External dependencies
 */
import { addFilter } from '@wordpress/hooks';

/**
 * Internal dependencies
 */
import './index.scss';

const MottaslPage = () => (
	<div>
		<h1>Integration Mottasl</h1>
		<p>
			An integration mottasl to show you how easy it is to send WA
			notifications using mottasl.
		</p>
		<br />
		{wooParams.integration_id ? (
			<p>
				Go to{' '}
				<a
					href={`https://ecom.mottasl.com?integration_id=${wooParams.integration_id}`}
					target="_blank"
					rel="noreferrer"
				>
					Mottasl Portal
				</a>{' '}
				to control notification templates.
			</p>
		) : (
			<p>
				Plugin installation was not successful. Contact mottasl support
				from <a href="https://mottasl.com/">here</a>.
			</p>
		)}
	</div>
);

addFilter('woocommerce_admin_pages_list', 'my-namespace', (pages) => {
	pages.push({
		container: MottaslPage,
		path: '/mottasl',
		breadcrumbs: ['Mottasl Page'],
		navArgs: {
			id: 'mottasl-page',
		},
	});

	return pages;
});
