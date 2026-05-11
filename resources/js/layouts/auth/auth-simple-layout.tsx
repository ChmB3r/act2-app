import { Link } from '@inertiajs/react';
import AppLogoIcon from '@/components/app-logo-icon';
import { home } from '@/routes';
import type { AuthLayoutProps } from '@/types';

export default function AuthSimpleLayout({
    children,
    title,
    description,
}: AuthLayoutProps) {
    return (
        <div className="flex min-h-svh flex-col items-center justify-center gap-6 bg-background p-6 md:p-10 relative overflow-hidden">
            {/* Background decorative elements */}
            <div className="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-purple-500/10 rounded-full blur-[120px]" />
            <div className="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-500/10 rounded-full blur-[120px]" />

            <div className="w-full max-w-sm z-10">
                <div className="flex flex-col gap-8">
                    <div className="flex flex-col items-center gap-4 text-center">
                        <Link
                            href={home()}
                            className="flex flex-col items-center gap-2 group transition-all"
                        >
                            <div className="mb-1 flex h-12 w-12 items-center justify-center rounded-xl bg-primary shadow-lg shadow-primary/20 group-hover:scale-110 transition-transform">
                                <span className="text-primary-foreground font-black text-2xl">M</span>
                            </div>
                            <span className="text-2xl font-black bg-linear-to-r from-purple-500 to-blue-500 bg-clip-text text-transparent italic">
                                Monarch's Archive
                            </span>
                        </Link>

                        <div className="space-y-2">
                            <h1 className="text-2xl font-bold tracking-tight">{title}</h1>
                            <p className="text-sm text-muted-foreground italic">
                                {description}
                            </p>
                        </div>
                    </div>
                    
                    <div className="bg-background/50 backdrop-blur-xl border border-border p-8 rounded-3xl shadow-2xl shadow-black/20">
                        {children}
                    </div>
                </div>
            </div>
        </div>
    );
}
