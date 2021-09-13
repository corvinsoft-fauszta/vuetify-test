<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <v-app>
        <v-navigation-drawer
            app
            permanent
            class="pt-4"
            color="grey lighten-3"
        >
            <v-list>
                <v-list-item link href="{{ route("home") }}">
                    <v-list-item-icon>
                        <v-icon>mdi-home</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>Home</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                @auth()
                    <v-list-item link href="{{ route("tickets.index") }}">
                        <v-list-item-icon>
                            <v-icon>mdi-ticket-outline</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Tickets</v-list-item-title>
                        </v-list-item-content>
                        @endauth()
                    </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-main>
            @yield('content')
        </v-main>
    </v-app>
</div>
</body>
</html>
