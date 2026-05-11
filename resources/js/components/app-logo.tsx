import AppLogoIcon from '@/components/app-logo-icon';

export default function AppLogo() {
    return (
        <>
            <div className="flex aspect-square size-8 items-center justify-center rounded-md bg-sidebar-primary text-sidebar-primary-foreground">
                <AppLogoIcon className="size-5 fill-current text-white dark:text-black" />
            </div>
            <div className="ml-1 grid flex-1 text-left text-sm">
                <span className="mb-0.5 truncate leading-tight font-black italic bg-linear-to-r from-purple-500 to-blue-500 bg-clip-text text-transparent uppercase tracking-tighter">
                    Monarch's Archive
                </span>
            </div>
        </>
    );
}
