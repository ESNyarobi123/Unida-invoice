<!DOCTYPE html>
<html lang="en">
    @php
        $today = ($today ?? now())->timezone('Africa/Dar_es_Salaam');
        $defaultInvoice = $defaultInvoice ?? 'UNIDA-' . $today->format('Y') . '-' . str_pad($today->format('z'), 3, '0', STR_PAD_LEFT);
    @endphp
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Unida Tech Limited | Smart Invoice Studio</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap"
            rel="stylesheet"
        />
        <style>
            :root {
                color-scheme: light;
                font-family: "Space Grotesk", "Segoe UI", sans-serif;
                --primary: #0054aa;
                --primary-dark: #002e68;
                --accent: #11a44c;
                --accent-soft: rgba(17, 164, 76, 0.15);
                --text: #0b1d32;
                --muted: #5f6b7c;
                --border: #e0e5ec;
                --bg: #f4f6fb;
                --panel: rgba(255, 255, 255, 0.92);
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                min-height: 100vh;
                background: radial-gradient(circle at 20% 20%, rgba(0, 84, 170, 0.15), transparent 50%),
                    radial-gradient(circle at 80% 0%, rgba(17, 164, 76, 0.2), transparent 50%), var(--bg);
                color: var(--text);
                padding: 32px clamp(16px, 5vw, 72px) 64px;
            }

            .surface {
                max-width: 1300px;
                margin: 0 auto;
                backdrop-filter: blur(18px);
                background: var(--panel);
                border-radius: 40px;
                border: 1px solid rgba(255, 255, 255, 0.5);
                box-shadow: 0 35px 120px rgba(11, 26, 60, 0.16);
                overflow: hidden;
            }

            .hero {
                display: grid;
                grid-template-columns: 1.4fr 0.8fr;
                gap: 32px;
                padding: clamp(32px, 5vw, 64px);
                background: linear-gradient(120deg, #003d7a, #0054aa 45%, #0b8c40);
                color: #fff;
                align-items: center;
            }

            .hero h1 {
                font-size: clamp(2rem, 3vw, 3.3rem);
                margin: 0;
                letter-spacing: 0.06em;
            }

            .hero p {
                margin: 8px 0 0;
                max-width: 540px;
                color: rgba(255, 255, 255, 0.86);
                font-size: 1.05rem;
            }

            .badge {
                display: inline-flex;
                gap: 10px;
                padding: 10px 18px;
                border-radius: 999px;
                background: rgba(255, 255, 255, 0.16);
                letter-spacing: 0.2em;
                text-transform: uppercase;
                font-size: 0.85rem;
                margin-bottom: 14px;
            }

            .hero-meta {
                text-align: right;
            }

            .hero-meta img {
                width: 120px;
                margin-bottom: 16px;
            }

            .user-card {
                background: rgba(255, 255, 255, 0.18);
                border-radius: 22px;
                padding: 16px;
                color: #fff;
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .user-card span {
                font-size: 0.95rem;
            }

            .user-card form {
                margin: 0;
            }

            .logout-btn {
                background: rgba(255, 255, 255, 0.12);
                border: 1px solid rgba(255, 255, 255, 0.3);
                color: #fff;
                border-radius: 999px;
                padding: 8px 16px;
                font-size: 0.85rem;
                cursor: pointer;
            }

            .workspace {
                display: grid;
                grid-template-columns: minmax(360px, 1.05fr) minmax(440px, 1.15fr);
                gap: 32px;
                padding: clamp(24px, 4vw, 52px);
            }

            .column {
                display: flex;
                flex-direction: column;
                gap: 24px;
            }

            .panel {
                background: #fff;
                border-radius: 30px;
                padding: 32px;
                border: 1px solid var(--border);
                box-shadow: 0 24px 70px rgba(8, 23, 63, 0.08);
            }

            .panel h2 {
                margin: 0 0 6px;
                font-size: 1.5rem;
            }

            .panel p {
                margin: 0 0 22px;
                color: var(--muted);
            }

            .brand-row {
                display: flex;
                align-items: center;
                gap: 16px;
                margin-bottom: 12px;
            }

            .brand-row img {
                width: 70px;
                border-radius: 16px;
            }

            form {
                display: flex;
                flex-direction: column;
                gap: 18px;
            }

            label {
                font-size: 0.88rem;
                font-weight: 600;
                color: var(--primary);
            }

            input,
            textarea,
            select {
                width: 100%;
                border: 1px solid var(--border);
                border-radius: 16px;
                padding: 14px 16px;
                font-size: 0.98rem;
                font-family: inherit;
                background: #fdfefe;
                transition: border 0.2s, box-shadow 0.2s;
            }

            textarea {
                min-height: 110px;
                resize: vertical;
            }

            input:focus,
            textarea:focus,
            select:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(0, 84, 170, 0.15);
            }

            .dual {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
                gap: 16px;
            }

            .quick-actions {
                display: flex;
                gap: 12px;
                margin-top: 8px;
                flex-wrap: wrap;
            }

            button {
                border: none;
                border-radius: 999px;
                padding: 12px 22px;
                font-weight: 600;
                cursor: pointer;
                font-family: inherit;
                transition: transform 0.1s ease, box-shadow 0.2s ease;
            }

            .primary-btn {
                background: var(--primary);
                color: #fff;
                box-shadow: 0 12px 32px rgba(0, 84, 170, 0.38);
            }

            .secondary-btn {
                background: var(--accent-soft);
                color: var(--accent);
            }

            .ghost-btn {
                background: rgba(0, 84, 170, 0.08);
                color: var(--primary);
            }

            .note {
                margin-top: 10px;
                background: rgba(0, 84, 170, 0.05);
                border-radius: 18px;
                padding: 14px 16px;
                font-size: 0.92rem;
                color: var(--primary-dark);
            }

            .history-panel h2 {
                margin-bottom: 4px;
            }

            .history-panel p {
                margin-bottom: 18px;
            }

            .history-glance {
                display: flex;
                gap: 10px;
                margin-bottom: 16px;
                flex-wrap: wrap;
            }

            .history-chip {
                border-radius: 999px;
                padding: 6px 14px;
                font-size: 0.82rem;
                background: rgba(0, 84, 170, 0.08);
                color: var(--primary-dark);
            }

            .history-list {
                display: flex;
                flex-direction: column;
                gap: 16px;
                max-height: 360px;
                overflow-y: auto;
                padding-right: 6px;
            }

            .history-item {
                display: grid;
                grid-template-columns: auto 1fr;
                gap: 12px;
            }

            .history-item .dot {
                width: 14px;
                height: 14px;
                border-radius: 50%;
                background: var(--accent);
                margin-top: 6px;
                box-shadow: 0 0 0 6px rgba(17, 164, 76, 0.12);
            }

            .history-card {
                border: 1px solid var(--border);
                border-radius: 16px;
                padding: 14px 16px;
                background: linear-gradient(120deg, rgba(0, 84, 170, 0.04), rgba(255, 255, 255, 0.95));
            }

            .history-card strong {
                font-size: 1rem;
                display: block;
            }

            .history-card span {
                display: block;
                font-size: 0.85rem;
                color: var(--muted);
            }

            .preview {
                position: relative;
                overflow: hidden;
            }

            .preview::before {
                content: "";
                position: absolute;
                inset: 18px;
                border-radius: 28px;
                border: 1px dashed rgba(0, 84, 170, 0.18);
                pointer-events: none;
            }

            .invoice {
                position: relative;
                background: #fff;
                border-radius: 22px;
                padding: 36px;
                display: flex;
                flex-direction: column;
                gap: 24px;
                min-height: 720px;
                box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.02);
            }

            .invoice-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 32px;
                margin-bottom: 24px;
                padding-bottom: 20px;
                border-bottom: 2px solid var(--primary);
            }

            .invoice-logo img {
                width: 120px;
                height: auto;
                object-fit: contain;
            }

            .invoice-company {
                flex: 1;
                text-align: right;
            }

            .invoice-title {
                font-size: 2.2rem;
                font-weight: 700;
                color: var(--primary);
                letter-spacing: 0.1em;
                margin-bottom: 12px;
            }

            .invoice-meta {
                font-size: 0.95rem;
                line-height: 1.8;
                color: var(--text);
            }

            .invoice-meta strong {
                color: var(--primary-dark);
            }

            .invoice-company-details {
                margin-bottom: 28px;
                padding-bottom: 20px;
                border-bottom: 1px solid var(--border);
                font-size: 0.95rem;
                line-height: 1.8;
                color: var(--text);
            }

            .invoice-company-details > div:first-child {
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--primary-dark);
                margin-bottom: 6px;
            }

            .divider {
                height: 3px;
                width: 80px;
                background: var(--accent);
                border-radius: 999px;
            }

            .summary-cards {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 16px;
            }

            .summary-card {
                border: 1px solid var(--border);
                border-radius: 18px;
                padding: 18px;
                background: linear-gradient(140deg, rgba(0, 84, 170, 0.04), rgba(255, 255, 255, 0.96));
            }

            .summary-card span {
                display: block;
                color: var(--muted);
                font-size: 0.82rem;
                text-transform: uppercase;
                letter-spacing: 0.16em;
            }

            .summary-card strong {
                font-size: 1.05rem;
                margin-top: 4px;
                color: var(--primary-dark);
            }

            .invoice-section {
                margin: 28px 0;
            }

            .section-title {
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--primary);
                letter-spacing: 0.1em;
                margin: 0 0 16px 0;
                text-transform: uppercase;
            }

            .invoice-table {
                width: 100%;
                border-collapse: collapse;
            }

            .invoice-table th {
                text-align: left;
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--text);
                padding: 10px 0 8px 0;
                width: 200px;
                vertical-align: top;
            }

            .invoice-table td {
                padding: 10px 0 8px 0;
                font-size: 0.95rem;
                color: var(--text);
                border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            }

            .invoice-table tr:last-child td {
                border-bottom: none;
            }

            .amount {
                font-size: 2rem;
                font-weight: 700;
                color: var(--primary-dark);
            }

            .footer {
                display: flex;
                justify-content: space-between;
                font-size: 0.95rem;
                color: var(--muted);
                flex-wrap: wrap;
                gap: 12px;
                padding-top: 12px;
            }

            .status {
                margin-top: 14px;
                font-size: 0.95rem;
            }

            .status.success {
                color: var(--accent);
            }

            .status.error {
                color: #c44545;
            }

            @media (max-width: 1100px) {
                .hero {
                    grid-template-columns: 1fr;
                    text-align: center;
                }

                .hero-meta {
                    text-align: center;
                }

                .workspace {
                    grid-template-columns: 1fr;
                }
            }

            @page {
                size: A4;
                margin: 16mm;
            }

            @media print {
                body {
                    padding: 0;
                    background: #fff;
                    color: #000;
                }

                .surface {
                    box-shadow: none;
                    border-radius: 0;
                    border: none;
                }

                .hero,
                .panel.builder,
                .history-panel {
                    display: none;
                }

                .workspace {
                    padding: 0;
                    display: block;
                }

                .panel.preview,
                .invoice {
                    display: block;
                    box-shadow: none;
                    border: none;
                    width: 100%;
                }

                .preview::before {
                    display: none;
                }

                #invoiceCanvas {
                    min-height: auto;
                    padding: 0;
                }
            }
        </style>
    </head>
    <body>
        <div class="surface">
            <section class="hero">
                <div>
                    <div class="badge">Smart · Secure · Connected</div>
                    <h1>Smart Invoice Studio</h1>
                    <p>
                        Karibu Unida Tech Limited. Jenga na print invoice ya mteja wako papo hapo kwa kutumia interface
                        hii ya kisasa—rahisi, kasi na yenye maelezo yote muhimu.
                    </p>
                </div>
                <div class="hero-meta">
                    <img src="{{ asset('images/unida-logo.svg') }}" alt="Unida Tech logo" />
                    <div class="user-card">
                        <span>{{ $user['email'] ?? '' }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="logout-btn">Toka / Logout</button>
                        </form>
                    </div>
                </div>
            </section>

            <div class="workspace">
                <div class="column">
                    <section class="panel builder">
                        <div class="brand-row">
                            <img src="{{ asset('images/unida.jpeg') }}" alt="Unida brand" />
                            <div>
                                <h2>Invoice Builder</h2>
                                <p>Weka taarifa za mteja na mradi, kisha angalia matokeo upande wa kulia.</p>
                            </div>
                        </div>

                        <form id="invoiceForm">
                            <div>
                                <label for="invoiceNumber">Invoice Number</label>
                                <input type="text" id="invoiceNumber" name="invoiceNumber" value="{{ $defaultInvoice }}" />
                            </div>
                            <div class="dual">
                                <div>
                                    <label for="issueDate">Issue Date</label>
                                    <input type="date" id="issueDate" name="issueDate" value="{{ $today->format('Y-m-d') }}" />
                                </div>
                                <div>
                                    <label for="supportLine">Support Line</label>
                                    <input type="text" id="supportLine" name="supportLine" value="+255 762 494 775" />
                                </div>
                            </div>
                            <hr style="border: none; border-top: 1px dashed var(--border); margin: 8px 0 4px" />
                            <strong>Bill To (Mteja)</strong>
                            <div>
                                <label for="clientName">Jina la Mteja</label>
                                <input type="text" id="clientName" name="clientName" placeholder="Ntalu Media" />
                            </div>
                            <div>
                                <label for="clientCompany">Company / Brand</label>
                                <input type="text" id="clientCompany" name="clientCompany" placeholder="Ntalu Digital" />
                            </div>
                            <div class="dual">
                                <div>
                                    <label for="clientEmail">Email</label>
                                    <input type="email" id="clientEmail" name="clientEmail" placeholder="client@email.com" />
                                </div>
                                <div>
                                    <label for="clientMobile">Mobile</label>
                                    <input type="tel" id="clientMobile" name="clientMobile" placeholder="+255..." />
                                </div>
                            </div>
                            <div>
                                <label for="clientLocation">Location</label>
                                <input type="text" id="clientLocation" name="clientLocation" placeholder="Dar es Salaam, Tanzania" />
                            </div>
                            <hr style="border: none; border-top: 1px dashed var(--border); margin: 8px 0 4px" />
                            <strong>Project Details</strong>
                            <div>
                                <label for="service">Service Summary</label>
                                <textarea
                                    id="service"
                                    name="service"
                                    placeholder="Website modification, social media creation, and admin panel development"
                                ></textarea>
                            </div>
                            <div>
                                <label for="website">Website / Platform</label>
                                <input type="text" id="website" name="website" placeholder="https://client-website.com" />
                            </div>
                            <div class="dual">
                                <div>
                                    <label for="currency">Currency</label>
                                    <select id="currency" name="currency">
                                        <option value="TZS">TZS</option>
                                        <option value="USD">USD</option>
                                        <option value="EUR">EUR</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="budget">Total Budget</label>
                                    <input type="number" id="budget" name="budget" placeholder="1500000" />
                                </div>
                            </div>
                            <div class="quick-actions">
                                <button type="button" class="primary-btn" id="printInvoice">Chapisha / Print</button>
                                <button type="button" class="ghost-btn" id="saveInvoice">Save to History</button>
                                <button type="button" class="secondary-btn" id="resetInvoice">Reset</button>
                            </div>
                            <div class="note">
                                Invoice be issued on 17th November 1.5m as 1st installement. Hakikisha malipo yamesajiliwa kabla
                                ya kuwasilisha.
                            </div>
                            <div id="status" class="status"></div>
                        </form>
                    </section>

                    <section class="panel history-panel">
                        <div class="brand-row" style="margin-bottom: 0">
                            <div>
                                <h2>Invoice History</h2>
                                <p>Muhtasari wa invoices ulizohifadhi leo na siku zilizopita.</p>
                            </div>
                        </div>
                        <div class="history-glance" id="historyChips">
                            @forelse ($history->take(3) as $entry)
                                <span class="history-chip">{{ $entry['invoiceNumber'] }}</span>
                            @empty
                                <span class="history-chip">Hakuna rekodi bado</span>
                            @endforelse
                        </div>
                        <div class="history-list" id="historyList">
                            @forelse ($history as $entry)
                                <div class="history-item">
                                    <div class="dot"></div>
                                    <div class="history-card">
                                        <strong>{{ $entry['invoiceNumber'] }}</strong>
                                        <span>{{ \Carbon\Carbon::parse($entry['issueDate'])->format('d M Y') }} · {{ $entry['clientName'] }}</span>
                                        <span>{{ $entry['currency'] }} {{ number_format($entry['budget']) }} • {{ $entry['created_by'] ?? '' }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="history-card">
                                    <strong>No invoices yet</strong>
                                    <span>Hifadhi invoice yako ya kwanza ili ionekane hapa.</span>
                                </div>
                            @endforelse
                        </div>
                    </section>
                </div>

                <section class="panel preview">
                    <div class="invoice" id="invoiceCanvas">
                        <header class="invoice-header">
                            <div class="invoice-logo">
                                <img src="{{ asset('images/unida.jpeg') }}" alt="Unida Tech Limited" />
                            </div>
                            <div class="invoice-company">
                                <div class="invoice-title">INVOICE</div>
                                <div class="invoice-meta">
                                    <div><strong>INVOICE NO.:</strong> <span id="previewInvoiceNumber">{{ $defaultInvoice }}</span></div>
                                    <div><strong>ISSUE DATE:</strong> <span id="previewIssueDate">{{ $today->format('d M Y') }}</span></div>
                                </div>
                            </div>
                        </header>

                        <div class="invoice-company-details">
                            <div><strong>UNIDA TECH LIMITED</strong></div>
                            <div>Address: 32649 Mabatini Road, 12 Mwenge Nzasa, Kinondoni, Dar es Salaam</div>
                            <div>Phone: <span id="previewSupportLine">+255 762 494 775</span></div>
                            <div>Email: info@unida.tech</div>
                            <div>Smart · Secure · Connected</div>
                        </div>

                        <div class="invoice-section">
                            <h3 class="section-title">BILL TO (MTEJA)</h3>
                            <table class="invoice-table">
                                <tbody>
                                    <tr>
                                        <th>NAME:</th>
                                        <td id="previewClientName">—</td>
                                    </tr>
                                    <tr>
                                        <th>COMPANY / BRAND:</th>
                                        <td id="previewClientCompany">—</td>
                                    </tr>
                                    <tr>
                                        <th>EMAIL:</th>
                                        <td id="previewClientEmail">—</td>
                                    </tr>
                                    <tr>
                                        <th>LOCATION:</th>
                                        <td id="previewClientLocation">—</td>
                                    </tr>
                                    <tr>
                                        <th>MOBILE:</th>
                                        <td id="previewClientMobile">—</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="invoice-section">
                            <h3 class="section-title">PROJECT DETAILS</h3>
                            <table class="invoice-table">
                                <tbody>
                                    <tr>
                                        <th>SERVICE:</th>
                                        <td id="previewService">
                                            Website modification, social media creation, and admin panel development
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>WEBSITE:</th>
                                        <td id="previewWebsite">—</td>
                                    </tr>
                                    <tr>
                                        <th>TOTAL PROJECT VALUE (BUDGET):</th>
                                        <td class="amount" id="previewBudget">TZS 0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="footer">
                            <div>
                                Kwa ufafanuzi zaidi tuandikie <strong>info@unida.tech</strong> au tupigie
                                <span id="footerSupport">+255 762 494 775</span>
                            </div>
                            <div>Smart · Secure · Connected</div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <script>
            const form = document.getElementById("invoiceForm");
            const historyList = document.getElementById("historyList");
            const historyChips = document.getElementById("historyChips");
            const statusBox = document.getElementById("status");
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            const initialHistory = @json($history);

            const fields = [
                ["invoiceNumber", "previewInvoiceNumber"],
                [
                    "issueDate",
                    "previewIssueDate",
                    (value) => {
                        if (!value) return "—";
                        const date = new Date(value);
                        return date.toLocaleDateString("en-GB", { day: "2-digit", month: "short", year: "numeric" });
                    },
                ],
                ["supportLine", "previewSupportLine"],
                ["supportLine", "footerSupport"],
                ["clientName", "previewClientName"],
                ["clientCompany", "previewClientCompany"],
                ["clientEmail", "previewClientEmail"],
                ["clientLocation", "previewClientLocation"],
                ["clientMobile", "previewClientMobile"],
                ["service", "previewService"],
                ["website", "previewWebsite"],
                [
                    "budget",
                    "previewBudget",
                    (value) => {
                        const currency = document.getElementById("currency").value;
                        if (!value) return `${currency} 0`;
                        const formatter = new Intl.NumberFormat("en-US");
                        return `${currency} ${formatter.format(value)}`;
                    },
                ],
            ];

            const renderHistory = (items) => {
                if (!historyList || !historyChips) return;

                if (!items.length) {
                    historyList.innerHTML =
                        '<div class="history-card"><strong>No invoices yet</strong><span>Hifadhi invoice yako ya kwanza ili ionekane hapa.</span></div>';
                    historyChips.innerHTML = '<span class="history-chip">Hakuna rekodi bado</span>';
                    return;
                }

                historyChips.innerHTML = items
                    .slice(0, 3)
                    .map((item) => `<span class="history-chip">${item.invoiceNumber}</span>`)
                    .join("");

                historyList.innerHTML = items
                    .map(
                        (item) => `
                        <div class="history-item">
                            <div class="dot"></div>
                            <div class="history-card">
                                <strong>${item.invoiceNumber}</strong>
                                <span>${new Date(item.issueDate).toLocaleDateString("en-GB", { day: "2-digit", month: "short", year: "numeric" })} · ${item.clientName}</span>
                                <span>${item.currency} ${Number(item.budget).toLocaleString()} • ${item.created_by ?? ""}</span>
                            </div>
                        </div>
                    `,
                    )
                    .join("");
            };

            renderHistory(initialHistory);

            const updatePreview = (fieldId) => {
                fields.forEach(([inputId, previewId, transformer]) => {
                    if (fieldId && fieldId !== inputId && inputId !== "currency") {
                        return;
                    }
                    const input = document.getElementById(inputId);
                    const preview = document.getElementById(previewId);
                    if (!input || !preview) return;
                    const value = input.value.trim();
                    preview.textContent = transformer ? transformer(value) : value || "—";
                });
                if (!fieldId || fieldId === "currency") {
                    const budgetInput = document.getElementById("budget");
                    const render = fields.find((f) => f[0] === "budget")[2];
                    document.getElementById("previewBudget").textContent = render(budgetInput.value.trim());
                }
            };

            form.addEventListener("input", (event) => {
                updatePreview(event.target.id);
            });

            document.getElementById("currency").addEventListener("change", () => updatePreview("currency"));

            document.getElementById("printInvoice").addEventListener("click", () => window.print());

            document.getElementById("resetInvoice").addEventListener("click", () => {
                form.reset();
                document.getElementById("invoiceNumber").value = "{{ $defaultInvoice }}";
                document.getElementById("issueDate").value = "{{ $today->format('Y-m-d') }}";
                document.getElementById("supportLine").value = "+255 762 494 775";
                document.getElementById("service").value =
                    "Website modification, social media creation, and admin panel development";
                updatePreview();
                statusBox.textContent = "";
                statusBox.className = "status";
            });

            document.getElementById("saveInvoice").addEventListener("click", async () => {
                statusBox.textContent = "Saving...";
                statusBox.className = "status";
                try {
                    const formData = new FormData(form);
                    const response = await fetch("{{ route('invoices.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                        },
                        body: formData,
                    });
                    if (!response.ok) {
                        throw await response.json();
                    }
                    const payload = await response.json();
                    renderHistory(payload.history);
                    statusBox.textContent = "Invoice saved and added to history.";
                    statusBox.className = "status success";
                } catch (error) {
                    statusBox.textContent =
                        (error && error.message) || "Imeshindikana kuhifadhi. Hakikisha sehemu zote zimejazwa.";
                    statusBox.className = "status error";
                }
            });

            updatePreview();
        </script>
    </body>
</html>

