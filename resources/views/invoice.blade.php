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
            href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Space+Grotesk:wght@300;400;500;600;700&display=swap"
            rel="stylesheet"
        />
        <style>
            :root {
                --primary: #0f4c81; /* Classic Blue */
                --primary-dark: #082d4f;
                --accent: #2e8b57; /* Sea Green */
                --accent-light: #e8f5e9;
                --text: #1e293b;
                --text-light: #64748b;
                --bg: #f1f5f9;
                --white: #ffffff;
                --border: #e2e8f0;
                --radius: 12px;
                --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            * {
                box-sizing: border-box;
                margin: 0;
                padding: 0;
            }

            body {
                font-family: 'Outfit', sans-serif;
                background: var(--bg);
                color: var(--text);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            /* Layout & Surface */
            .app-container {
                max-width: 1400px;
                margin: 0 auto;
                padding: 2rem;
                width: 100%;
                display: grid;
                grid-template-columns: 400px 1fr;
                gap: 2rem;
                align-items: start;
            }

            .panel {
                background: var(--white);
                border-radius: var(--radius);
                box-shadow: var(--shadow);
                padding: 1.5rem;
                border: 1px solid var(--border);
            }

            /* Header / Nav */
            .app-header {
                background: var(--primary);
                color: white;
                padding: 1rem 2rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
                box-shadow: var(--shadow);
            }

            .app-brand {
                font-family: 'Space Grotesk', sans-serif;
                font-weight: 700;
                font-size: 1.5rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .user-menu {
                display: flex;
                align-items: center;
                gap: 1rem;
                font-size: 0.9rem;
            }

            .logout-btn {
                background: rgba(255,255,255,0.2);
                border: none;
                color: white;
                padding: 0.5rem 1rem;
                border-radius: 2rem;
                cursor: pointer;
                transition: background 0.2s;
            }

            .logout-btn:hover {
                background: rgba(255,255,255,0.3);
            }

            /* Form Styles */
            .form-group {
                margin-bottom: 1rem;
            }

            label {
                display: block;
                font-size: 0.85rem;
                font-weight: 500;
                color: var(--text-light);
                margin-bottom: 0.4rem;
            }

            input, select, textarea {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid var(--border);
                border-radius: 8px;
                font-family: inherit;
                font-size: 0.95rem;
                transition: border-color 0.2s;
            }

            input:focus, select:focus, textarea:focus {
                outline: none;
                border-color: var(--primary);
                box-shadow: 0 0 0 3px rgba(15, 76, 129, 0.1);
            }

            textarea {
                resize: vertical;
                min-height: 80px;
            }

            .row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            .section-divider {
                height: 1px;
                background: var(--border);
                margin: 1.5rem 0;
                position: relative;
            }

            .section-divider span {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: var(--white);
                padding: 0 0.5rem;
                color: var(--text-light);
                font-size: 0.8rem;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .actions {
                display: flex;
                gap: 1rem;
                margin-top: 1.5rem;
            }

            .btn {
                flex: 1;
                padding: 0.8rem;
                border: none;
                border-radius: 8px;
                font-weight: 600;
                cursor: pointer;
                transition: transform 0.1s;
            }

            .btn:active {
                transform: scale(0.98);
            }

            .btn-primary {
                background: var(--primary);
                color: white;
            }

            .btn-secondary {
                background: var(--accent-light);
                color: var(--accent);
            }

            .btn-ghost {
                background: transparent;
                color: var(--text-light);
                border: 1px solid var(--border);
            }

            /* Invoice Preview - The "Amazing" Part */
            .invoice-preview-container {
                background: #525659; /* PDF viewer background feel */
                padding: 2rem;
                border-radius: var(--radius);
                overflow: auto;
                display: flex;
                justify-content: center;
            }

            .invoice-paper {
                background: white;
                width: 210mm; /* A4 width */
                min-height: 297mm; /* A4 height */
                padding: 0; /* We'll manage padding inside */
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
                position: relative;
                display: flex;
                flex-direction: column;
            }

            /* Invoice Content Styling */
            .inv-header {
                text-align: center;
                padding: 3rem 3rem 1rem;
            }

            .inv-title {
                color: var(--primary);
                font-family: 'Space Grotesk', sans-serif;
                font-size: 2rem;
                font-weight: 700;
                letter-spacing: 0.05em;
                margin-bottom: 0.2rem;
                text-transform: uppercase;
            }

            .inv-tagline {
                color: var(--accent);
                font-size: 0.9rem;
                letter-spacing: 0.1em;
                font-weight: 500;
            }

            .inv-body {
                padding: 2rem 3rem;
                flex: 1;
            }

            .inv-meta-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
                margin-bottom: 3rem;
                border-top: 2px solid var(--primary);
                border-bottom: 2px solid var(--primary);
                padding: 1.5rem 0;
            }

            .inv-label {
                font-size: 0.75rem;
                color: var(--text-light);
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin-bottom: 0.25rem;
            }

            .inv-value {
                font-size: 1rem;
                font-weight: 600;
                color: var(--text);
            }

            .inv-value.large {
                font-size: 1.1rem;
                color: var(--primary);
            }

            .inv-table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 2rem;
            }

            .inv-table th {
                text-align: left;
                background: var(--bg);
                padding: 0.8rem 1rem;
                font-size: 0.8rem;
                text-transform: uppercase;
                color: var(--primary);
                font-weight: 700;
            }

            .inv-table td {
                padding: 1rem;
                border-bottom: 1px solid var(--border);
                vertical-align: top;
            }

            .inv-description {
                font-size: 0.95rem;
                line-height: 1.6;
                color: var(--text);
                white-space: pre-wrap;
            }

            .inv-total-section {
                display: flex;
                justify-content: flex-end;
                margin-top: 1rem;
            }

            .inv-total-box {
                background: var(--primary);
                color: white;
                padding: 1rem 2rem;
                border-radius: 8px;
                text-align: right;
                min-width: 250px;
            }

            .inv-total-label {
                font-size: 0.8rem;
                opacity: 0.9;
                margin-bottom: 0.2rem;
            }

            .inv-total-amount {
                font-size: 1.8rem;
                font-weight: 700;
            }

            .inv-footer {
                text-align: center;
                padding: 2rem 3rem 3rem;
                font-size: 0.85rem;
                color: var(--primary);
                border-top: 1px solid var(--border);
                margin-top: auto;
            }

            .inv-footer-company {
                font-weight: 700;
                text-transform: uppercase;
                margin-bottom: 0.5rem;
            }

            .inv-footer-address {
                margin-bottom: 0.5rem;
                color: var(--text);
            }

            .inv-footer-contact {
                display: flex;
                justify-content: center;
                gap: 1.5rem;
                color: var(--text-light);
            }

            .inv-footer-contact span {
                display: flex;
                align-items: center;
                gap: 0.4rem;
            }

            /* History Panel */
            .history-list {
                margin-top: 1rem;
                display: flex;
                flex-direction: column;
                gap: 0.8rem;
            }

            .history-item {
                padding: 0.8rem;
                border: 1px solid var(--border);
                border-radius: 8px;
                font-size: 0.9rem;
                cursor: pointer;
                transition: background 0.1s;
            }

            .history-item:hover {
                background: var(--bg);
            }

            .status {
                margin-top: 1rem;
                padding: 0.8rem;
                border-radius: 8px;
                font-size: 0.9rem;
                display: none;
            }

            .status.success { display: block; background: #dcfce7; color: #166534; }
            .status.error { display: block; background: #fee2e2; color: #991b1b; }

            /* Print Styles */
            @media print {
                body {
                    background: white;
                    display: block;
                    height: auto;
                    overflow: visible;
                }
                
                .app-header, 
                .panel.builder {
                    display: none !important;
                }

                .app-container {
                    display: block !important;
                    width: 100%;
                    margin: 0;
                    padding: 0;
                    max-width: none;
                }

                .invoice-preview-container {
                    background: white;
                    padding: 0;
                    margin: 0;
                    display: block !important;
                    border: none;
                    overflow: visible;
                }

                .invoice-paper {
                    box-shadow: none;
                    width: 100%;
                    margin: 0;
                    padding: 0;
                    border: none;
                }

                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }

                @page { 
                    margin: 0;
                    size: auto;
                }
            }
            
            @media (max-width: 1100px) {
                .app-container {
                    grid-template-columns: 1fr;
                }
                .invoice-paper {
                    width: 100%;
                    min-height: auto;
                }
            }
        </style>
    </head>
    <body>
        <header class="app-header">
            <div class="app-brand">
                <span>Unida Invoice</span>
            </div>
            <div class="user-menu">
                <span>{{ $user['email'] ?? '' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        </header>

        <div class="app-container">
            <!-- Builder Panel -->
            <div class="panel builder">
                <h2 style="margin-bottom: 1.5rem; color: var(--primary);">Invoice Details</h2>
                <form id="invoiceForm">
                    <div class="form-group">
                        <label>Invoice Number</label>
                        <input type="text" id="invoiceNumber" name="invoiceNumber" value="{{ $defaultInvoice }}" />
                    </div>
                    
                    <div class="row">
                        <div class="form-group">
                            <label>Issue Date</label>
                            <input type="date" id="issueDate" name="issueDate" value="{{ $today->format('Y-m-d') }}" />
                        </div>
                        <div class="form-group">
                            <label>Currency</label>
                            <select id="currency" name="currency">
                                <option value="TZS">TZS</option>
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                            </select>
                        </div>
                    </div>

                    <div class="section-divider"><span>CLIENT</span></div>

                    <div class="form-group">
                        <label>Client Name</label>
                        <input type="text" id="clientName" name="clientName" placeholder="e.g. John Doe" />
                    </div>
                    <div class="form-group">
                        <label>Company / Brand</label>
                        <input type="text" id="clientCompany" name="clientCompany" placeholder="e.g. Acme Corp" />
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="clientEmail" name="clientEmail" placeholder="client@example.com" />
                        </div>
                        <div class="form-group">
                            <label>Mobile</label>
                            <input type="tel" id="clientMobile" name="clientMobile" placeholder="+255..." />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" id="clientLocation" name="clientLocation" placeholder="City, Country" />
                    </div>

                    <div class="section-divider"><span>PROJECT</span></div>

                    <div class="form-group">
                        <label>Service Description</label>
                        <textarea id="service" name="service" placeholder="Describe the services provided..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Website / Link</label>
                        <input type="text" id="website" name="website" placeholder="https://..." />
                    </div>
                    <div class="form-group">
                        <label>Total Budget</label>
                        <input type="number" id="budget" name="budget" placeholder="0.00" />
                    </div>

                    <!-- Hidden fields for fixed data -->
                    <input type="hidden" id="supportLine" name="supportLine" value="+255 762 494 775">

                    <div class="actions">
                        <button type="button" class="btn btn-ghost" id="resetInvoice">Reset</button>
                        <button type="button" class="btn btn-secondary" id="saveInvoice">Save</button>
                        <button type="button" class="btn btn-primary" id="printInvoice">Print</button>
                    </div>
                    <div id="status" class="status"></div>
                </form>

                <div style="margin-top: 2rem;">
                    <h3 style="font-size: 1rem; color: var(--text-light); margin-bottom: 1rem;">Recent History</h3>
                    <div id="historyList" class="history-list">
                        <!-- JS will populate this -->
                    </div>
                </div>
            </div>

            <!-- Preview Panel -->
            <div class="invoice-preview-container">
                <div class="invoice-paper" id="invoiceCanvas">
                    <!-- Header -->
                    <div class="inv-header">
                        <div class="inv-title">UNIDA TECH LIMITED</div>
                        <div class="inv-tagline">Smart. Secure. Connected.</div>
                    </div>

                    <!-- Body -->
                    <div class="inv-body">
                        <div class="inv-meta-grid">
                            <div>
                                <div class="inv-label">Billed To</div>
                                <div class="inv-value large" id="previewClientName">—</div>
                                <div class="inv-value" id="previewClientCompany" style="font-weight: 400; margin-top: 4px;">—</div>
                                <div style="margin-top: 8px; font-size: 0.9rem; color: var(--text-light);">
                                    <div id="previewClientLocation">—</div>
                                    <div id="previewClientEmail">—</div>
                                    <div id="previewClientMobile">—</div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <div class="inv-label">Invoice Details</div>
                                <div style="margin-bottom: 8px;">
                                    <span class="inv-label">NO:</span>
                                    <span class="inv-value" id="previewInvoiceNumber">{{ $defaultInvoice }}</span>
                                </div>
                                <div>
                                    <span class="inv-label">DATE:</span>
                                    <span class="inv-value" id="previewIssueDate">{{ $today->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <table class="inv-table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th style="width: 150px; text-align: right;">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="inv-value" style="margin-bottom: 0.5rem;">Project Services</div>
                                        <div class="inv-description" id="previewService">Website modification, social media creation, and admin panel development</div>
                                        <div style="margin-top: 0.5rem; font-size: 0.85rem; color: var(--text-light);">
                                            Platform: <span id="previewWebsite">—</span>
                                        </div>
                                    </td>
                                    <td style="text-align: right;">
                                        <div class="inv-value" id="previewBudget">TZS 0</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="inv-total-section">
                            <div class="inv-total-box">
                                <div class="inv-total-label">TOTAL DUE</div>
                                <div class="inv-total-amount" id="previewTotal">TZS 0</div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="inv-footer">
                        <div class="inv-footer-company">UNIDA TECH LIMITED</div>
                        <div class="inv-footer-address">Mabatini Road, 12 Mwenge Nzasa, Kijitonyama 32649, Dar es Salaam, Tanzania</div>
                        <div class="inv-footer-contact">
                            <span>✉ info@unida.tech</span>
                            <span>🌐 https://unida.tech</span>
                            <span>📞 +255 762 494 775</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            const form = document.getElementById("invoiceForm");
            const historyList = document.getElementById("historyList");
            const statusBox = document.getElementById("status");
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            const initialHistory = @json($history);

            // Mapping: [InputID, PreviewID, OptionalFormatter]
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
                if (!historyList) return;

                if (!items.length) {
                    historyList.innerHTML = '<div style="color: var(--text-light); font-size: 0.9rem;">No invoices saved yet.</div>';
                    return;
                }

                historyList.innerHTML = items
                    .map(
                        (item) => `
                        <div class="history-item" onclick="loadHistoryItem('${item.invoiceNumber}')">
                            <div style="font-weight: 600; color: var(--primary);">${item.invoiceNumber}</div>
                            <div style="display: flex; justify-content: space-between; margin-top: 4px; color: var(--text-light); font-size: 0.8rem;">
                                <span>${item.clientName}</span>
                                <span>${item.currency} ${Number(item.budget).toLocaleString()}</span>
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
                
                // Update Total Box as well
                if (!fieldId || fieldId === "budget" || fieldId === "currency") {
                    const budgetInput = document.getElementById("budget");
                    const currencyInput = document.getElementById("currency");
                    const render = fields.find((f) => f[0] === "budget")[2];
                    const totalText = render(budgetInput.value.trim());
                    document.getElementById("previewTotal").textContent = totalText;
                }
            };

            form.addEventListener("input", (event) => {
                updatePreview(event.target.id);
            });

            document.getElementById("currency").addEventListener("change", () => updatePreview("currency"));

            document.getElementById("printInvoice").addEventListener("click", () => window.print());

            document.getElementById("resetInvoice").addEventListener("click", () => {
                form.reset();
                // Reset defaults
                document.getElementById("invoiceNumber").value = "{{ $defaultInvoice }}";
                document.getElementById("issueDate").value = "{{ $today->format('Y-m-d') }}";
                updatePreview();
                statusBox.style.display = 'none';
            });

            document.getElementById("saveInvoice").addEventListener("click", async () => {
                statusBox.textContent = "Saving...";
                statusBox.className = "status";
                statusBox.style.display = 'block';
                
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
                    statusBox.textContent = "Invoice saved successfully!";
                    statusBox.className = "status success";
                } catch (error) {
                    statusBox.textContent =
                        (error && error.message) || "Failed to save invoice. Please check inputs.";
                    statusBox.className = "status error";
                }
            });

            // Initial render
            updatePreview();
        </script>
    </body>
</html>
