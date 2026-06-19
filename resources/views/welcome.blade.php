<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Render Test') }}</title>
    <style>
        :root {
            color-scheme: light;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f6f8fb;
            color: #172033;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 32px;
        }

        main {
            width: min(720px, 100%);
            background: #ffffff;
            border: 1px solid #dde4ef;
            border-radius: 8px;
            padding: 34px;
            box-shadow: 0 18px 50px rgba(23, 32, 51, 0.08);
        }

        h1 {
            margin: 0 0 12px;
            font-size: clamp(2rem, 5vw, 3.6rem);
            line-height: 1;
        }

        p {
            color: #526174;
            font-size: 1.05rem;
            line-height: 1.6;
            margin: 0;
        }

        .stats {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            margin-top: 28px;
        }

        .stat {
            border: 1px solid #e5ebf3;
            border-radius: 8px;
            padding: 18px;
            background: #fbfcfe;
        }

        .label {
            color: #6b778c;
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .value {
            display: block;
            margin-top: 8px;
            font-size: 1.45rem;
            font-weight: 800;
            overflow-wrap: anywhere;
        }
    </style>
</head>
<body>
    <main>
        <h1>Render Test</h1>
        <p>Una app Laravel sencilla usando SQLite. Cada visita a esta pagina se guarda en la base de datos.</p>

        <section class="stats" aria-label="Estado de la aplicacion">
            <div class="stat">
                <span class="label">Framework</span>
                <span class="value">Laravel {{ app()->version() }}</span>
            </div>
            <div class="stat">
                <span class="label">Base de datos</span>
                <span class="value">SQLite</span>
            </div>
            <div class="stat">
                <span class="label">Visitas</span>
                <span class="value">{{ number_format($visitCount) }}</span>
            </div>
            <div class="stat">
                <span class="label">Archivo SQLite</span>
                <span class="value">{{ $databasePath }}</span>
            </div>
        </section>
    </main>
</body>
</html>
