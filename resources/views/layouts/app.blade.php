<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta id="token" name="csrf-token" content="{{ csrf_token() }}">
    @auth()
        <script>
            window.Laravel = <?php echo json_encode(['api_token' => (Auth::user())->api_token]); ?>
        </script>
    @endauth

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
                    </v-list-item>
                @endauth()

            </v-list>
            @auth()
                <template v-slot:append>
                    <form ref="logout" method="POST" action="{{ route("logout") }}">
                        @csrf
                        <v-list-item role="button">
                            <v-list-item-icon>
                                <v-icon>mdi-logout-variant</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content @click="$refs['logout'].submit();">
                                Logout
                            </v-list-item-content>
                        </v-list-item>
                    </form>
                </template>
            @endauth
        </v-navigation-drawer>
        <v-main>
            @yield('content')
        </v-main>
    </v-app>
</div>
</body>
</html>
