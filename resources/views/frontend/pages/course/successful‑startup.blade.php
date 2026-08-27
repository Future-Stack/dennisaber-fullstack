@extends('frontend.layouts.app')

@section('contents')
    <main class="course-landing cat-business" style="background: #0f172a; color: #f8fafc; font-family: var(--font-geist-sans, sans-serif);">
        {{-- Top Notification --}}
        <div class="portal-notice">
            <strong>Technisches Kursportal</strong>
            <span><a href="{{ route('home') }}">← Zurück zur gesamten Kursübersicht</a></span>
        </div>

        {{-- Header --}}
        <header class="portal-header course-header" style="border-bottom: 1px solid #1e293b;">
            <a href="{{ route('home') }}" class="portal-brand">
                <strong>DENNIS BESSELER</strong>
                <span>Startup Advisory</span>
            </a>
            <nav>
                <a href="{{ route('home') }}">Alle Kurse</a>
                <a href="{{ route('login') }}">Kundenlogin</a>
                <a href="{{ route('copy-protection') }}">Kopierschutz</a>
                <a href="{{ route('payment') }}">Zahlung</a>
                <a href="#anmelden" style="color: #38bdf8; font-weight: bold;">Anmelden</a>
            </nav>
        </header>

        {{-- Hero Section --}}
        <section style="max-width: 1200px; margin: 0 auto; padding: 4rem 1.5rem 3rem; display: grid; grid-template-columns: 1.2fr 1fr; gap: 3rem; align-items: start;">
            <div>
                <p style="font-size: 0.85rem; color: #f59e0b; text-transform: uppercase; font-weight: bold; letter-spacing: 0.1em; margin-bottom: 1rem;">
                    Full Course Details · Business Set-up with Practical Experience
                </p>
                <h1 style="font-size: 3rem; line-height: 1.1; font-weight: 900; margin: 0 0 1.5rem 0; text-transform: uppercase;">
                    SUCCESSFUL<br/>STARTUPS.<br/>
                    <span style="color: transparent; -webkit-text-stroke: 1.5px #f8fafc;">WITH REAL<br/>PERFORMANCE.</span>
                </h1>
                <p style="font-size: 1.05rem; line-height: 1.6; color: #cbd5e1; margin-bottom: 2rem;">
                    Dennis Besseler has built several companies himself — with limited budgets, zero promotion, real marketing, and responsibility for his own decisions. This course gives you the tools to turn your business idea into reality.
                </p>

                <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
                    <a href="#anfrage" style="background: #eab308; color: #0f172a; font-weight: bold; padding: 0.85rem 1.5rem; border-radius: 4px; text-decoration: none; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.05em;">
                        Go to Inquiry Form / Call 02234 9397768
                    </a>
                    <a href="#anmelden" style="background: #1e293b; color: #f8fafc; font-weight: bold; padding: 0.85rem 1.5rem; border-radius: 4px; text-decoration: none; text-transform: uppercase; font-size: 0.85rem; border: 1px solid #334155;">
                        Register Purchased Course
                    </a>
                </div>
            </div>

            {{-- Direct Login Box --}}
            <aside class="course-login" id="anmelden" style="background: #1e293b; border-radius: 12px; padding: 2rem; border: 1px solid #334155;">
                <p class="login-label" style="color: #eab308; font-size: 0.85rem; text-transform: uppercase; font-weight: bold; margin-bottom: 0.5rem;">Bereits freigeschaltet?</p>
                <h2 style="color: #f8fafc; font-size: 1.4rem; margin-top: 0; margin-bottom: 1.25rem;">Persönlichen Kurs öffnen</h2>

                <form method="POST" action="{{ route('login.store') }}" autocomplete="off">
                    @csrf
                    <label style="display: block; margin-bottom: 1rem;">
                        <span style="display: block; font-size: 0.85rem; color: #94a3b8; margin-bottom: 0.35rem;">Benutzername oder E-Mail</span>
                        <input type="text" name="login" required autocomplete="username" placeholder="z. B. testkunde" style="width: 100%; padding: 0.75rem; background: #0f172a; border: 1px solid #334155; border-radius: 6px; color: #fff;"/>
                    </label>
                    <label style="display: block; margin-bottom: 1.25rem;">
                        <span style="display: block; font-size: 0.85rem; color: #94a3b8; margin-bottom: 0.35rem;">Passwort</span>
                        <input type="password" name="password" required autocomplete="current-password" placeholder="Ihr Passwort" style="width: 100%; padding: 0.75rem; background: #0f172a; border: 1px solid #334155; border-radius: 6px; color: #fff;"/>
                    </label>

                    <input type="hidden" name="device_id" class="course_device_id">
                    <input type="hidden" name="device_name" class="course_device_name">

                    <button type="submit" style="width: 100%; background: #0284c7; color: #fff; font-weight: bold; padding: 0.85rem; border: none; border-radius: 6px; cursor: pointer; font-size: 1rem;">
                        Anmelden und Kurs öffnen <span>→</span>
                    </button>
                </form>

                <a href="{{ route('forgot-password') }}" class="password-forgotten-link" style="display: block; margin-top: 1rem; color: #38bdf8; font-size: 0.85rem; text-decoration: none;">
                    Benutzername oder Passwort vergessen?
                </a>
                <p class="login-help" style="color: #64748b; font-size: 0.8rem; margin-top: 0.75rem; line-height: 1.4;">
                    Sicherheitshinweis: Der persönliche Zugang wird beim ersten Login dynamisch Ihrem Gerät zugeordnet.
                </p>
            </aside>
        </section>

        {{-- Experience Section --}}
        <section style="background: #fdfbf7; color: #0f172a; padding: 4rem 1.5rem;">
            <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1.3fr 1fr; gap: 3.5rem;">
                <div>
                    <p style="font-size: 0.85rem; color: #b45309; text-transform: uppercase; font-weight: bold; letter-spacing: 0.1em; margin-bottom: 0.75rem;">
                        Experience Instead of Empty Theories
                    </p>
                    <h2 style="font-size: 2.3rem; line-height: 1.15; font-weight: 900; margin: 0 0 1.5rem 0; text-transform: uppercase;">
                        DIDN'T READ ABOUT FOUNDING A COMPANY.<br/>FOUNDED IT MYSELF.
                    </h2>
                    <p style="font-size: 1rem; line-height: 1.7; color: #475569;">
                        Dennis Besseler's background in business founding goes beyond consulting and webinars. He has built companies, developed his own products, and navigated both success and failure from the front lines. Rather than theoretical concepts, you'll learn the practical mechanics of positioning, market outreach, customer acquisition, and daily business operations.
                    </p>
                </div>

                {{-- Specs Box --}}
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.75rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 0.75rem; font-size: 0.9rem; padding: 0.5rem 0; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b;">Target Audience</span>
                        <strong>Future entrepreneurs and founders</strong>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 0.75rem; font-size: 0.9rem; padding: 0.5rem 0; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b;">Format</span>
                        <strong>Comprehensive online video course</strong>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 0.75rem; font-size: 0.9rem; padding: 0.5rem 0; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b;">Duration</span>
                        <strong>Three months dedicated access</strong>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 0.75rem; font-size: 0.9rem; padding: 0.5rem 0; border-bottom: 1px solid #e2e8f0;">
                        <span style="color: #64748b;">Output</span>
                        <strong>Verifiable business foundation, positioning, and action plan</strong>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 0.75rem; font-size: 0.9rem; padding: 0.5rem 0;">
                        <span style="color: #64748b;">Certificate</span>
                        <strong>Verifiable graduation certificate</strong>
                    </div>
                </div>
            </div>

            {{-- Stat Numbers --}}
            <div style="max-width: 1200px; margin: 3rem auto 0; display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; border-top: 1px solid #e2e8f0; padding-top: 2.5rem;">
                <div>
                    <strong style="font-size: 2rem; color: #b45309; display: block;">4</strong>
                    <span style="font-weight: bold; color: #0f172a; display: block;">Weeks guided learning</span>
                    <small style="color: #64748b;">Comprehensive video modules with step-by-step guidance</small>
                </div>
                <div>
                    <strong style="font-size: 2rem; color: #b45309; display: block;">24</strong>
                    <span style="font-weight: bold; color: #0f172a; display: block;">Interactive units</span>
                    <small style="color: #64748b;">Deep-dive analyses, real business exercises and templates</small>
                </div>
                <div>
                    <strong style="font-size: 2rem; color: #b45309; display: block;">30+</strong>
                    <span style="font-weight: bold; color: #0f172a; display: block;">30-day plan</span>
                    <small style="color: #64748b;">Clear framework to test, launch, and acquire your first clients</small>
                </div>
            </div>
        </section>

        {{-- Roadmap Section --}}
        <section style="background: #fdfbf7; color: #0f172a; padding: 2rem 1.5rem 4rem; border-top: 1px solid #e2e8f0;">
            <div style="max-width: 1200px; margin: 0 auto;">
                <p style="font-size: 0.85rem; color: #b45309; text-transform: uppercase; font-weight: bold; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
                    ROADMAP
                </p>
                <h2 style="font-size: 2.2rem; font-weight: 900; margin: 0 0 2rem 0; text-transform: uppercase;">
                    FROM IDEA TO VERIFIABLE FOUNDATION.
                </h2>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
                    <div style="background: #fff; padding: 1.5rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <span style="color: #b45309; font-weight: bold; font-size: 0.85rem;">Day 1</span>
                        <h3 style="margin: 0.5rem 0; font-size: 1.15rem;">Foundation &amp; Positioning</h3>
                        <p style="color: #64748b; font-size: 0.9rem; margin: 0;">Market definition, value proposition, and customer avatar validation.</p>
                    </div>
                    <div style="background: #fff; padding: 1.5rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <span style="color: #b45309; font-weight: bold; font-size: 0.85rem;">Day 2</span>
                        <h3 style="margin: 0.5rem 0; font-size: 1.15rem;">Offers &amp; Structure Plans</h3>
                        <p style="color: #64748b; font-size: 0.9rem; margin: 0;">Pricing strategies, financial budgeting, and risk mitigation models.</p>
                    </div>
                    <div style="background: #fff; padding: 1.5rem; border: 1px solid #e2e8f0; border-radius: 8px;">
                        <span style="color: #b45309; font-weight: bold; font-size: 0.85rem;">Day 3</span>
                        <h3 style="margin: 0.5rem 0; font-size: 1.15rem;">Testing &amp; Implementation</h3>
                        <p style="color: #64748b; font-size: 0.9rem; margin: 0;">Sales communication, initial customer outreach, and operational kickoff.</p>
                    </div>
                </div>

                <div style="background: #f1f5f9; padding: 1rem 1.5rem; border-radius: 6px; font-size: 0.85rem; color: #475569; text-align: center; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 500;">
                    ALL THREE DAYS INCLUDE IMMEDIATE ACCESS TO INTERACTIVE EXERCISES, DECISION-MAKING CHECKS, AND DOWNLOADABLE WORKSHEETS.
                </div>
            </div>
        </section>

        {{-- Audio Player & Workbook Interactive Section --}}
        <section style="background: #064e3b; color: #f8fafc; padding: 4rem 1.5rem;">
            <div style="max-width: 1200px; margin: 0 auto;">
                <p style="font-size: 0.85rem; color: #fde047; text-transform: uppercase; font-weight: bold; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
                    Original Material &amp; Interactive Exercise
                </p>
                <h2 style="font-size: 2.2rem; font-weight: 900; margin: 0 0 1rem 0; text-transform: uppercase;">
                    FOUR ORIGINAL AUDIO FILES AND THE WORKBOOK.
                </h2>
                <p style="color: #a7f3d0; margin-bottom: 2rem; font-size: 1rem;">
                    One entry is available directly on this page: No form, no email address, and no registration required.
                </p>

                {{-- Audio List --}}
                <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 2.5rem;">
                    <div style="background: #022c22; padding: 1rem 1.5rem; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #047857;">
                        <span style="font-weight: bold;">🎧 A01 - Etappe 1</span>
                        <audio controls style="max-width: 400px; width: 100%;">
                            <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4" type="audio/mp4">
                        </audio>
                    </div>
                    <div style="background: #022c22; padding: 1rem 1.5rem; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #047857;">
                        <span style="font-weight: bold;">🎧 A02 - Etappe 2</span>
                        <audio controls style="max-width: 400px; width: 100%;">
                            <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4" type="audio/mp4">
                        </audio>
                    </div>
                    <div style="background: #022c22; padding: 1rem 1.5rem; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #047857;">
                        <span style="font-weight: bold;">🎧 A03 - Etappe 3</span>
                        <audio controls style="max-width: 400px; width: 100%;">
                            <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4" type="audio/mp4">
                        </audio>
                    </div>
                    <div style="background: #022c22; padding: 1rem 1.5rem; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #047857;">
                        <span style="font-weight: bold;">🎧 A04 - Etappe 4</span>
                        <audio controls style="max-width: 400px; width: 100%;">
                            <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4" type="audio/mp4">
                        </audio>
                    </div>
                </div>
            </div>
        </section>

        {{-- Related Courses --}}
        <section style="background: #fdfbf7; color: #0f172a; padding: 4rem 1.5rem;">
            <div style="max-width: 1200px; margin: 0 auto;">
                <p style="font-size: 0.85rem; color: #b45309; text-transform: uppercase; font-weight: bold; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
                    Suitable Extensions from our Program
                </p>
                <h2 style="font-size: 2.2rem; font-weight: 900; margin: 0 0 2rem 0; text-transform: uppercase;">
                    TWO IN-DEPTH ANALYSES FROM REAL-WORLD PRACTICE.
                </h2>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem;">
                    <div style="background: #fff; padding: 2rem; border-radius: 8px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <span style="color: #b45309; font-weight: bold; font-size: 0.85rem; text-transform: uppercase;">Presse &amp; Öffentlichkeit</span>
                            <h3 style="font-size: 1.4rem; margin: 0.5rem 0;">Press &amp; Public Relations</h3>
                            <p style="color: #64748b; line-height: 1.6; font-size: 0.95rem;">
                                Concrete media strategy and targeted press communication developed directly on your own real project.
                            </p>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
                            <strong style="font-size: 1.3rem;">390 €</strong>
                            <a href="{{ route('course-press-public') }}" style="background: #eab308; color: #0f172a; font-weight: bold; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">
                                Details →
                            </a>
                        </div>
                    </div>

                    <div style="background: #fff; padding: 2rem; border-radius: 8px; border: 1px solid #e2e8f0; display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <span style="color: #b45309; font-weight: bold; font-size: 0.85rem; text-transform: uppercase;">Rhetorik &amp; Wirkung</span>
                            <h3 style="font-size: 1.4rem; margin: 0.5rem 0;">Rhetoric under pressure</h3>
                            <p style="color: #64748b; line-height: 1.6; font-size: 0.95rem;">
                                Confident argumentation and communication tools during difficult negotiation and high-stress situations.
                            </p>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
                            <strong style="font-size: 1.3rem;">249 €</strong>
                            <a href="{{ route('course-under-pressure') }}" style="background: #eab308; color: #0f172a; font-weight: bold; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">
                                Details →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Order & Inquiry Section --}}
        <section id="anfrage" style="background: #020617; color: #f8fafc; padding: 4rem 1.5rem; border-top: 1px solid #1e293b;">
            <div style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 1.2fr 1fr; gap: 3rem; align-items: center;">
                <div>
                    <p style="font-size: 0.85rem; color: #eab308; text-transform: uppercase; font-weight: bold; letter-spacing: 0.1em; margin-bottom: 0.5rem;">
                        Contact &amp; Order Process
                    </p>
                    <h2 style="font-size: 2.8rem; font-weight: 900; line-height: 1.1; margin: 0 0 1.5rem 0; text-transform: uppercase;">
                        INQUIRE.<br/>SEND ORDER FORM.<br/>GET STARTED.
                    </h2>
                    <p style="color: #94a3b8; font-size: 1rem; line-height: 1.6;">
                        Your message is not a binding order. We prepare the complete order form for you without hassle, explain terms in detail, verify your expectations, and only proceed if both sides agree. Professional, confidential, and focused on clarity and solid business foundations.
                    </p>
                </div>

                <div style="background: #0f172a; padding: 2rem; border-radius: 12px; border: 1px solid #1e293b;">
                    <form method="POST" action="{{ route('inquiry.mailto') }}">
                        @csrf
                        <input type="hidden" name="course" value="Erfolgreich gründen (1.690 €)"/>
                        <label style="display: block; margin-bottom: 1rem;">
                            <span style="font-size: 0.85rem; color: #94a3b8;">Vorname *</span>
                            <input type="text" name="first_name" required placeholder="Ihr Vorname" style="width: 100%; padding: 0.75rem; background: #1e293b; border: 1px solid #334155; border-radius: 6px; color: #fff; margin-top: 0.25rem;"/>
                        </label>
                        <label style="display: block; margin-bottom: 1rem;">
                            <span style="font-size: 0.85rem; color: #94a3b8;">E-Mail-Adresse *</span>
                            <input type="email" name="email" required placeholder="Ihre E-Mail" style="width: 100%; padding: 0.75rem; background: #1e293b; border: 1px solid #334155; border-radius: 6px; color: #fff; margin-top: 0.25rem;"/>
                        </label>
                        <label style="display: block; margin-bottom: 1.25rem;">
                            <span style="font-size: 0.85rem; color: #94a3b8;">Ihre Nachricht / Fragen</span>
                            <textarea name="message" rows="3" placeholder="Ihre Notiz zum Vorhaben" style="width: 100%; padding: 0.75rem; background: #1e293b; border: 1px solid #334155; border-radius: 6px; color: #fff; margin-top: 0.25rem;"></textarea>
                        </label>
                        <button type="submit" style="width: 100%; background: #eab308; color: #0f172a; font-weight: bold; padding: 0.85rem; border: none; border-radius: 6px; cursor: pointer; text-transform: uppercase; font-size: 0.9rem;">
                            Order Bindingly / 1.690 € / Tax Free
                        </button>
                    </form>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="site-footer" style="border-top: 1px solid #1e293b;">
            <div>
                <strong>DENNIS BESSELER</strong>
                <p>Persönliche Kurszugänge · einmalige Zahlung · kein Abonnement</p>
            </div>
            <nav aria-label="Rechtliche Hinweise">
                <a href="{{ route('login') }}">Kundenlogin</a>
                <a href="{{ route('copy-protection') }}">Kopierschutz</a>
                <a href="{{ route('payment') }}">Zahlung</a>
                <a href="{{ route('imprint') }}">Impressum</a>
                <a href="{{ route('privacy-policy') }}">Datenschutz</a>
            </nav>
        </footer>
    </main>

    <script>
        (() => {
            const deviceName = navigator.platform + " | " + navigator.userAgent;
            const raw = navigator.userAgent + navigator.platform + screen.width + screen.height + Intl.DateTimeFormat().resolvedOptions().timeZone;

            async function sha256(text) {
                const buffer = await crypto.subtle.digest("SHA-256", new TextEncoder().encode(text));
                return [...new Uint8Array(buffer)].map(b => b.toString(16).padStart(2, "0")).join("");
            }

            sha256(raw).then(hash => {
                document.querySelectorAll('.course_device_id').forEach(el => el.value = hash);
                document.querySelectorAll('.course_device_name').forEach(el => el.value = deviceName);
            });
        })();
    </script>
@endsection
