export function classNames(items: object|string[]): string {
    if (Array.isArray(items)) {
        return items
            .filter(
                (value) => typeof value !== null
            )
            .join(' ');
    }

    return Array(
        Object.entries(items)
            .filter(
                ([className, state]) => state
            )
            .keys()
        )
        .join(' ');
}
