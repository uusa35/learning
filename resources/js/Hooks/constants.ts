export const myChannel = window.Echo.channel("my-channel");
export const transitionClasses = {
    enter: 'transform transition duration-[400ms]',
    enterFrom: 'opacity-0 rotate-[-120deg] scale-50',
    enterTo: 'opacity-100 rotate-0 scale-100',
    leave: 'transform duration-200 transition ease-in-out',
    leaveFrom: 'opacity-100 rotate-0 scale-100',
    leaveTo: 'opacity-0 scale-95',
};

