<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            @keyframes bounce {
                0%, 20%, 53%, 80%, 100% {
                    transform: translate3d(0,0,0);
                }
                40%, 43% {
                    transform: translate3d(0,-30px,0);
                }
                70% {
                    transform: translate3d(0,-15px,0);
                }
                90% {
                    transform: translate3d(0,-4px,0);
                }
            }
            
            @keyframes pulse {
                0%, 100% {
                    opacity: 1;
                }
                50% {
                    opacity: 0.5;
                }
            }

            @keyframes float {
                0%, 100% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-10px);
                }
            }

            .gradient-text {
                background: linear-gradient(135deg, #8FA4B3, #6C8AA0, #4F738D);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }
        </style>
    </head>
    <body>
        <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #dee2e6 100%); background-image: radial-gradient(at 30% 40%, rgba(143, 164, 179, 0.3) 0, transparent 50%), radial-gradient(at 80% 0%, rgba(108, 138, 160, 0.2) 0, transparent 50%), radial-gradient(at 0% 50%, rgba(79, 115, 141, 0.1) 0, transparent 50%); position: relative; overflow: hidden;">
            <!-- Floating background elements -->
            <div style="position: absolute; top: 10%; left: 10%; width: 100px; height: 100px; background: linear-gradient(135deg, rgba(143, 164, 179, 0.1), rgba(108, 138, 160, 0.1)); border-radius: 50%; animation: float 6s ease-in-out infinite;"></div>
            <div style="position: absolute; top: 60%; right: 15%; width: 60px; height: 60px; background: linear-gradient(135deg, rgba(108, 138, 160, 0.1), rgba(79, 115, 141, 0.1)); border-radius: 50%; animation: float 4s ease-in-out infinite reverse;"></div>
            
            <div style="max-width: 48rem; width: 100%; text-align: center; padding: 0 1.5rem; position: relative; z-index: 10;">
                
                <!-- Error Icon with Animation -->
                <div style="margin-bottom: 3rem;">
                    <div style="margin: 0 auto 2rem; width: 10rem; height: 10rem; background: linear-gradient(135deg, #8FA4B3 0%, #6C8AA0 50%, #4F738D 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 25px 50px -12px rgba(79, 115, 141, 0.4), 0 0 0 3px rgba(255, 255, 255, 0.8); animation: bounce 1s infinite; position: relative;">
                        <div style="position: absolute; inset: -3px; background: linear-gradient(45deg, #8FA4B3, #6C8AA0, #4F738D, #8FA4B3); border-radius: 50%; z-index: -1; opacity: 0.3; animation: pulse 3s infinite;"></div>
                        <div style="width: 9rem; height: 9rem; background: rgba(255, 255, 255, 0.9); border-radius: 50%; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(8px); border: 2px solid rgba(255, 255, 255, 0.5);">
                            <svg style="width: 5rem; height: 5rem; color: #4F738D; animation: pulse 2s infinite; filter: drop-shadow(0 4px 8px rgba(79, 115, 141, 0.2));" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Content Section -->
                <div class="content">
                    <!-- Error Code -->
                    <h1 style="font-size: 9rem; font-weight: 900; margin-bottom: 1.5rem; background: linear-gradient(135deg, #8FA4B3 0%, #6C8AA0 50%, #4F738D 100%); -webkit-background-clip: text; background-clip: text; color: transparent; animation: pulse 2s infinite; text-shadow: 0 25px 50px rgba(79, 115, 141, 0.2);">
                        @yield('code', '404')
                    </h1>
                    
                    <!-- Error Message -->
                    <h2 style="font-size: 2.25rem; font-weight: 700; color: #4F738D; margin-bottom: 1.5rem; text-shadow: 0 10px 15px rgba(79, 115, 141, 0.1);">
                        @yield('message')
                    </h2>

                    <!-- Error Description -->
                    <p style="font-size: 1.25rem; color: #6C8AA0; line-height: 1.75; max-width: 28rem; margin: 0 auto;">
                        @yield('description', __('Oops! The page you are looking for seems to have wandered off into the digital void. Let\'s get you back home.'))
                    </p>
                </div>
                
                <!-- Enhanced Action Buttons -->
                <div style="margin-top: 2rem;">
                    <!-- Primary Button -->
                    <a href="/" 
                       style="display: inline-flex; align-items: center; padding: 1.25rem 2.5rem; background: linear-gradient(135deg, #8FA4B3 0%, #6C8AA0 50%, #4F738D 100%); color: white; font-weight: 700; font-size: 1.125rem; border-radius: 1rem; text-decoration: none; box-shadow: 0 25px 50px -12px rgba(79, 115, 141, 0.4), 0 0 0 2px rgba(255, 255, 255, 0.3); transition: all 0.3s ease; margin-bottom: 1.5rem; position: relative; overflow: hidden;"
                       onmouseover="this.style.transform='scale(1.08) translateY(-6px)'; this.style.boxShadow='0 35px 60px -12px rgba(79, 115, 141, 0.6), 0 0 30px rgba(143, 164, 179, 0.4)';"
                       onmouseout="this.style.transform='scale(1) translateY(0px)'; this.style.boxShadow='0 25px 50px -12px rgba(79, 115, 141, 0.4), 0 0 0 2px rgba(255, 255, 255, 0.3)';">
                        <div style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent, rgba(255,255,255,0.1)); transform: translateX(-100%); transition: transform 0.6s ease;"></div>
                        <svg style="width: 1.5rem; height: 1.5rem; margin-right: 0.75rem; position: relative; z-index: 2;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        <span style="position: relative; z-index: 2;">{{ __('Take Me Home') }}</span>
                    </a>
                    
                    <!-- Secondary Button -->
                    <div>
                        <a href="javascript:history.back()" 
                           style="display: inline-flex; align-items: center; padding: 1rem 2rem; background: rgba(255, 255, 255, 0.6); color: #4F738D; font-weight: 600; border-radius: 0.75rem; text-decoration: none; border: 1px solid rgba(143, 164, 179, 0.3); backdrop-filter: blur(8px); transition: all 0.3s ease; box-shadow: 0 10px 25px -5px rgba(79, 115, 141, 0.1);"
                           onmouseover="this.style.transform='scale(1.05) translateY(-2px)'; this.style.background='rgba(255, 255, 255, 0.8)'; this.style.boxShadow='0 20px 35px -5px rgba(79, 115, 141, 0.2)';"
                           onmouseout="this.style.transform='scale(1) translateY(0px)'; this.style.background='rgba(255, 255, 255, 0.6)'; this.style.boxShadow='0 10px 25px -5px rgba(79, 115, 141, 0.1)';">
                            <svg style="width: 1.25rem; height: 1.25rem; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            {{ __('Go Back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>