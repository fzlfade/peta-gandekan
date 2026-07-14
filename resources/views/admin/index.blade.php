<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Data Warga Gandekan</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --background: 0 0% 100%;
            --foreground: 0 0% 3.6%;
            --card: 0 0% 100%;
            --card-foreground: 0 0% 3.6%;
            --muted: 0 0% 96.1%;
            --muted-foreground: 0 0% 45.1%;
            --border: 0 0% 89.8%;
            --input: 0 0% 89.8%;
            --primary: 200 100% 50%;
            --primary-foreground: 0 0% 100%;
            --destructive: 0 84% 60%;
            --destructive-foreground: 0 0% 100%;
            --radius: 0.5rem;
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --background: 0 0% 3.6%;
                --foreground: 0 0% 98.2%;
                --card: 0 0% 10%;
                --card-foreground: 0 0% 98.2%;
                --muted: 0 0% 14.9%;
                --muted-foreground: 0 0% 63.9%;
                --border: 0 0% 14.9%;
                --input: 0 0% 14.9%;
                --primary: 200 100% 50%;
                --primary-foreground: 0 0% 0%;
            }
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: hsl(var(--background)); color: hsl(var(--foreground)); }
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem 1rem; }
        .card { background: hsl(var(--card)); border: 1px solid hsl(var(--border)); border-radius: var(--radius); padding: 1.5rem; }
        .flex { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; }
        .gap-2 { gap: 0.5rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .text-lg { font-size: 1.125rem; }
        .font-bold { font-weight: 700; }
        .text-sm { font-size: 0.875rem; }
        .text-xs { font-size: 0.75rem; }
        .text-muted { color: hsl(var(--muted-foreground)); }
        .text-center { text-align: center; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 0.75rem 0.5rem; border-bottom: 1px solid hsl(var(--border)); font-size: 0.875rem; }
        th { font-weight: 600; color: hsl(var(--muted-foreground)); }
        tr:hover td { background: hsl(var(--muted) / 0.5); }
        .btn {
            display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.5rem 1rem;
            border-radius: var(--radius); font-size: 0.875rem; font-weight: 500;
            text-decoration: none; border: 1px solid transparent; cursor: pointer;
            transition: all 0.15s; font-family: inherit;
        }
        .btn-primary { background: hsl(var(--primary)); color: hsl(var(--primary-foreground)); }
        .btn-primary:hover { opacity: 0.9; }
        .btn-outline { background: transparent; color: hsl(var(--foreground)); border-color: hsl(var(--border)); }
        .btn-outline:hover { background: hsl(var(--muted)); }
        .btn-destructive { background: hsl(var(--destructive)); color: hsl(var(--destructive-foreground)); }
        .btn-destructive:hover { opacity: 0.9; }
        .btn-sm { padding: 0.25rem 0.75rem; font-size: 0.75rem; }
        .alert { padding: 0.75rem 1rem; border-radius: var(--radius); font-size: 0.875rem; margin-bottom: 1rem; }
        .alert-success { background: hsl(160 84% 39% / 0.15); color: hsl(160 84% 39%); border: 1px solid hsl(160 84% 39% / 0.3); }
        .grid-cols { display: grid; gap: 1rem; }
        .col-span-2 { grid-column: span 2; }
        label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem; }
        input, textarea {
            width: 100%; padding: 0.5rem 0.75rem; border: 1px solid hsl(var(--input));
            border-radius: var(--radius); font-size: 0.875rem; background: hsl(var(--card));
            color: hsl(var(--foreground)); font-family: inherit;
        }
        input:focus, textarea:focus { outline: none; border-color: hsl(var(--primary)); box-shadow: 0 0 0 2px hsl(var(--primary) / 0.2); }
        .pagination { display: flex; justify-content: center; gap: 0.5rem; margin-top: 1.5rem; flex-wrap: wrap; }
        .pagination a, .pagination span {
            padding: 0.375rem 0.75rem; border-radius: var(--radius); font-size: 0.875rem;
            text-decoration: none; border: 1px solid hsl(var(--border)); color: hsl(var(--foreground));
        }
        .pagination a:hover { background: hsl(var(--muted)); }
        .pagination .active { background: hsl(var(--primary)); color: hsl(var(--primary-foreground)); border-color: hsl(var(--primary)); }
        @media (max-width: 768px) { .grid-cols { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="flex mb-6">
            <div>
                <h1 class="text-lg font-bold">Data Warga</h1>
                <p class="text-sm text-muted">Kelola data rumah warga Gandekan</p>
            </div>
            <a href="{{ route('admin.create') }}" class="btn btn-primary">+ Tambah Data</a>
        </div>

        <div class="card">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pemilik</th>
                            <th>Alamat</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th style="text-align:center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($wargas as $w)
                            <tr>
                                <td class="text-muted">{{ $w->id }}</td>
                                <td>{{ $w->nama_pemilik }}</td>
                                <td class="text-sm text-muted" style="max-width:300px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $w->alamat }}</td>
                                <td class="text-xs">{{ $w->latitude }}</td>
                                <td class="text-xs">{{ $w->longitude }}</td>
                                <td style="text-align:center">
                                    <a href="{{ route('admin.edit', $w) }}" class="btn btn-outline btn-sm">Edit</a>
                                    <form action="{{ route('admin.destroy', $w) }}" method="POST" style="display:inline"
                                        onsubmit="return confirm('Hapus data {{ $w->nama_pemilik }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-destructive btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted" style="padding:2rem;">Belum ada data warga.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination">
            {{ $wargas->links() }}
        </div>
    </div>
</body>
</html>
