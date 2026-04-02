<!doctype html>
<html lang="en" data-theme="{{ $config->get('ui.theme', 'light') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="color-scheme" content="{{ $config->get('ui.theme', 'light') }}">
    <title>{{ $config->get('ui.title') ?? config('app.name') . ' - API Docs' }}</title>

    <script src="https://unpkg.com/@stoplight/elements@8.4.2/web-components.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@stoplight/elements@8.4.2/styles.min.css">

    <script>
        const originalFetch = window.fetch;
        const SCRAMBLE_TOKEN_KEY = 'scramble_bearer_token';
        const SCRAMBLE_AUTH_VALUES_KEY = 'TryIt_securitySchemeValues';
        const SCRAMBLE_SECURITY_SCHEME_KEY = 'sanctum';

        const readStoredAuthValues = () => {
            try {
                const rawValues = window.localStorage.getItem(SCRAMBLE_AUTH_VALUES_KEY);
                return rawValues ? JSON.parse(rawValues) : {};
            } catch (_) {
                return {};
            }
        };

        const writeStoredAuthValues = (values) => {
            if (!values || Object.keys(values).length === 0) {
                window.localStorage.removeItem(SCRAMBLE_AUTH_VALUES_KEY);
                return;
            }

            window.localStorage.setItem(SCRAMBLE_AUTH_VALUES_KEY, JSON.stringify(values));
        };

        const getStoredToken = () => {
            const authValues = readStoredAuthValues();
            return authValues?.[SCRAMBLE_SECURITY_SCHEME_KEY] || window.localStorage.getItem(SCRAMBLE_TOKEN_KEY) || '';
        };

        const setStoredToken = (token) => {
            if (!token) {
                window.localStorage.removeItem(SCRAMBLE_TOKEN_KEY);
                const authValues = readStoredAuthValues();
                delete authValues[SCRAMBLE_SECURITY_SCHEME_KEY];
                writeStoredAuthValues(authValues);
                return;
            }

            window.localStorage.setItem(SCRAMBLE_TOKEN_KEY, token);

            const authValues = readStoredAuthValues();
            authValues[SCRAMBLE_SECURITY_SCHEME_KEY] = token;
            writeStoredAuthValues(authValues);
        };

        const getCookieValue = (key) => {
            const cookie = document.cookie
                .split(';')
                .find((item) => item.trim().startsWith(key));
            return cookie?.split('=')[1];
        };

        const updateFetchHeaders = (headers, headerKey, headerValue) => {
            if (headers instanceof Headers) {
                headers.set(headerKey, headerValue);
            } else if (Array.isArray(headers)) {
                const index = headers.findIndex(([key]) => key.toLowerCase() === headerKey.toLowerCase());
                if (index >= 0) {
                    headers[index] = [headerKey, headerValue];
                } else {
                    headers.push([headerKey, headerValue]);
                }
            } else if (headers) {
                headers[headerKey] = headerValue;
            }
        };

        const hasHeader = (headers, headerKey) => {
            if (headers instanceof Headers) {
                return headers.has(headerKey);
            }

            if (Array.isArray(headers)) {
                return headers.some(([key]) => key.toLowerCase() === headerKey.toLowerCase());
            }

            return Boolean(headers?.[headerKey] || headers?.[headerKey.toLowerCase()]);
        };

        const normalizeToken = (token) => {
            if (typeof token !== 'string') {
                return null;
            }

            const trimmedToken = token.trim();
            return trimmedToken.length ? trimmedToken.replace(/^Bearer\s+/i, '') : null;
        };

        const readTokenFromPayload = async (response) => {
            const contentType = response.headers.get('content-type') || '';

            if (!contentType.includes('application/json')) {
                return normalizeToken(response.headers.get('authorization'));
            }

            try {
                const payload = await response.clone().json();
                return normalizeToken(
                    payload?.data?.access_token
                    || payload?.data?.accessToken
                    || payload?.data?.token
                    || payload?.access_token
                    || payload?.accessToken
                    || payload?.token
                    || response.headers.get('authorization')
                );
            } catch (_) {
                return normalizeToken(response.headers.get('authorization'));
            }
        };

        window.fetch = async (url, options) => {
            const requestUrl = typeof url === 'string' ? url : (url?.url || '');
            const headers = options?.headers || new Headers();
            const isApiRequest = requestUrl.includes('/api/');
            const isAuthEndpoint = requestUrl.includes('/login') || requestUrl.includes('/register');

            const csrfToken = getCookieValue('XSRF-TOKEN');
            if (csrfToken && !hasHeader(headers, 'X-XSRF-TOKEN')) {
                updateFetchHeaders(headers, 'X-XSRF-TOKEN', decodeURIComponent(csrfToken));
            }

            const bearerToken = getStoredToken();
            if (bearerToken && isApiRequest && !isAuthEndpoint) {
                updateFetchHeaders(headers, 'Authorization', `Bearer ${bearerToken}`);
            }

            const response = await originalFetch(url, {
                ...(options || {}),
                headers,
            });

            if (isAuthEndpoint) {
                const responseToken = await readTokenFromPayload(response);
                if (responseToken) {
                    setStoredToken(responseToken);
                }
            }

            if (requestUrl.includes('/logout') && response.ok) {
                setStoredToken('');
            }

            return response;
        };
    </script>

    <style>
        html, body { margin:0; height:100%; }
        body { background-color: var(--color-canvas); }
        [data-theme="dark"] .token.property {
            color: rgb(128, 203, 196) !important;
        }
        [data-theme="dark"] .token.operator {
            color: rgb(255, 123, 114) !important;
        }
        [data-theme="dark"] .token.number {
            color: rgb(247, 140, 108) !important;
        }
        [data-theme="dark"] .token.string {
            color: rgb(165, 214, 255) !important;
        }
        [data-theme="dark"] .token.boolean {
            color: rgb(121, 192, 255) !important;
        }
        [data-theme="dark"] .token.punctuation {
            color: #dbdbdb !important;
        }
    </style>
</head>
<body style="height: 100vh; overflow-y: hidden">
<elements-api
    id="docs"
    tryItCredentialsPolicy="{{ $config->get('ui.try_it_credentials_policy', 'include') }}"
    router="hash"
    @if($config->get('ui.hide_try_it')) hideTryIt="true" @endif
    @if($config->get('ui.hide_schemas')) hideSchemas="true" @endif
    @if($config->get('ui.logo')) logo="{{ $config->get('ui.logo') }}" @endif
    @if($config->get('ui.layout')) layout="{{ $config->get('ui.layout') }}" @endif
/>
<script>
    (() => {
        const docs = document.getElementById('docs');
        docs.apiDescriptionDocument = @json($spec);
    })();
</script>

@if($config->get('ui.theme', 'light') === 'system')
    <script>
        var mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

        function updateTheme(e) {
            if (e.matches) {
                window.document.documentElement.setAttribute('data-theme', 'dark');
                window.document.getElementsByName('color-scheme')[0].setAttribute('content', 'dark');
            } else {
                window.document.documentElement.setAttribute('data-theme', 'light');
                window.document.getElementsByName('color-scheme')[0].setAttribute('content', 'light');
            }
        }

        mediaQuery.addEventListener('change', updateTheme);
        updateTheme(mediaQuery);
    </script>
@endif
</body>
</html>
